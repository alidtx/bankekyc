<?php


namespace App\Modules\DocumentValidatorMiddleTier\Services;
use App\Modules\DocumentValidatorMiddleTier\Models\FaceCompareLog;
use App\Modules\DocumentValidatorMiddleTier\Models\OcrLog;
use App\Traits\ApiResponseTrait;
use App\Traits\GuzzleRequestTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GazeIDService
{
    use GuzzleRequestTrait, ApiResponseTrait;

    public function gazeCompareFace(Request $request)
    {
    
        try {
            
            if (!$request->nid_front_image_path)
                return $this->invalidResponse('Document Image is missing or invalid image! PLease try again with valid image');
            if (!$request->selfie_image_path)
                return $this->invalidResponse('Selfie missing or invalid format');
            $nominee_face_match = $this->guzzlePostGaze(config('ekyc.api_gaze_url'), 'nid', $request->nid_front_image_path, $request->selfie_image_path);
            $faceResult = \GuzzleHttp\json_decode($nominee_face_match->getBody());
            Log::debug('get gaze response for nominee faces: ' . print_r($faceResult, true));
            if ($faceResult->success == 1 && $faceResult->matched == 1) {
                FaceCompareLog::create([
                    'image1_path' => $request->nid_front_image_path,
                    'image2_path' => $request->selfie_image_path,
                    'compare_type' => 'nid',
                    'score' => $faceResult->results[0]->score,
                    'matched' => $faceResult->results[0]->matched,
                    'face_compare_status' => 'success',
                    'source_url' => '',
                    'source_id' => '',
                ]);
                return $this->successResponse('Face compare successfully done', $faceResult->results);
            }


            FaceCompareLog::create([
                'image1_path' => Carbon::now()->format('YmdHis') . '_' . $request->nid_front_image_path,
                'image2_path' => Carbon::now()->format('YmdHis') . '_' . $request->selfie_image_path,
                'compare_type' => 'nid',
//                'score' => $faceResult->results->score,
//                'matched' => $faceResult->results->matched,
                'face_compare_status' => 'fail',
                'source_url' => '',
                'source_id' => '',
            ]);
            return $this->invalidResponse('Unable to compare the face! Please try again later');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }



    public function gazeNIDOCR(Request $request)
    {
        try {
            if (!$request->nid_front_image_path)
                return $this->invalidResponse('NID front Image missing or invalid format');
           $callNomineeNidOcr = $this->guzzlePostGaze(config('ekyc.api_gaze_url'), 'BD/read_nid', $request->nid_front_image_path); 
            $getNomineeOcr = \GuzzleHttp\json_decode($callNomineeNidOcr->getBody());
            Log::debug('get gaze response for nid orc: ' . print_r($getNomineeOcr, true));
            if ($getNomineeOcr->success == true &&
                !isset($getNomineeOcr->error_message) &&
                count($getNomineeOcr->results) == 1) {
                Log::debug('get gaze response for nid ocr success =>  ' . print_r($getNomineeOcr, true));
                $data['name'] = $getNomineeOcr->results[0]->name ?? '--';
                $data['dob'] = $getNomineeOcr->results[0]->dob ?? '--';
                $data['nid'] = $getNomineeOcr->results[0]->nid ?? '--';
                OcrLog::create([
                    'image_path' => Carbon::now()->format('YmdHis') . '_' . $request->nid_front_image_path,
                    'id_card_type' => 'nid',
                    'id_card_no' => $data['nid'],
                    'ocr_data' => json_encode($data),
                    'ocr_status' => 'success',
                    'ocr_fail_reason' => '',
                    'source_url' => $request->source_url ?? '',
                    'source_id' => $request->source_id ?? '',
                ]);
                return $this->successResponse('OCR successfully done', $data);//@todo need to check the data format
            }
            OcrLog::create([
                'image_path' => $request->nid_front_image_path,
                'id_card_type' => 'nid',
                'ocr_status' => 'fail',
                'ocr_fail_reason' => $getNomineeOcr->error_message ?? 'Error from mother server',
                'source_url' => $request->source_url ?? '',
                'source_id' => $request->source_id ?? '',
            ]);
            return $this->invalidResponse($getNomineeOcr->error_message ?? 'Unable to OCR the NID! Please try again later');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }



    public function gazeCompareFaceWithOCR(Request $request)
    {
        
        try {
           
            if ($file = $request->file('image1')) {
                $filename_image1 = str_replace(' ', '', $file->getClientOriginalName());
                $file->move(public_path('images/image1/'), $filename_image1);
                $filepath_image1 = 'images/image1/' . $filename_image1;
            } else {
                return $this->invalidResponse('Selfie missing or invalid format');
            }
            if ($file = $request->file('image2')) {
                $filename_image2 = str_replace(' ', '', $file->getClientOriginalName());
                $file->move(public_path('images/image2/'), $filename_image2);
                $filepath_image2 = 'images/image2/' . $filename_image2;
            } else {
                return $this->invalidResponse('Selfie missing or invalid format');
            }


            $nominee_face_match = $this->guzzlePostGaze(config('ekyc.api_gaze_url'), 'compare_faces', $filepath_image1, $filepath_image2);
            $faceResult = \GuzzleHttp\json_decode($nominee_face_match->getBody());
            Log::debug('get gaze response for nominee faces: ' . print_r($faceResult, true));
            if ($faceResult->success == 1 && $faceResult->matched == 1) {
                $data['is_nominee_verified'] = 1;
                $callNomineeNidOcr = $this->guzzlePostGaze(config('ekyc.api_gaze_url'), 'BD/read_image2', $filepath_image2);
                $getNomineeOcr = \GuzzleHttp\json_decode($callNomineeNidOcr->getBody());
                Log::debug('get gaze response for nominee image2 ocr: ' . print_r($getNomineeOcr, true));

                $data['nominee_1_name'] = $getNomineeOcr->results[0]->name ?? '--';
                $data['nominee_1_relation'] = $request->nominee_1_relation ?? '--';
                $data['nominee_1_dob'] = $getNomineeOcr->results[0]->dob ?? '--';
                $data['image2_no'] = $getNomineeOcr->results[0]->image2 ?? '--';
                //@todo need to insert data into orc_logs and face_compare db
                return $this->successResponse('Face compare successfully done', $data);//@todo need to check data format
            }
            return $this->invalidResponse('Unable to compare the face! Please try again later');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }



    public function documentAINIDOCR(Request $request)
    {
        try {
            if (!$request->nid_front_image_path)
                return $this->invalidResponse('NID front Image missing or invalid format');
            $callNomineeNidOcr = $this->guzzlePostGaze(config('ekyc.api_docai_ocr_url'), 'nid_ocr', $request->nid_front_image_path);//document ai
            $getNomineeOcr = \GuzzleHttp\json_decode($callNomineeNidOcr->getBody());
            Log::debug('get gaze response for nid orc: ' . print_r($getNomineeOcr, true));
            if ($getNomineeOcr->status == 200) {
                Log::debug('get gaze response for nid ocr success =>  ' . print_r($getNomineeOcr, true));
                $data['name'] = $getNomineeOcr->data->name ?? '--';
                $data['dob'] = $getNomineeOcr->data->dob ?? '--';
                $data['nid'] = $getNomineeOcr->data->nid ?? '--';
                OcrLog::create([
                    'image_path' => Carbon::now()->format('YmdHis') . '_' . $request->nid_front_image_path,
                    'id_card_type' => 'nid',
                    'id_card_no' => $data['nid'],
                    'ocr_data' => json_encode($data),
                    'ocr_status' => 'success',
                    'ocr_fail_reason' => '',
                    'source_url' => $request->source_url ?? '',
                    'source_id' => $request->source_id ?? '',
                ]);
                return $this->successResponse('OCR successfully done', $data);//@todo need to check the data format
            }
            OcrLog::create([
                'image_path' => $request->nid_front_image_path,
                'id_card_type' => 'nid',
                'ocr_status' => 'fail',
                'ocr_fail_reason' => $getNomineeOcr->error_message ?? 'Error from mother server',
                'source_url' => $request->source_url ?? '',
                'source_id' => $request->source_id ?? '',
            ]);
            return $this->invalidResponse($getNomineeOcr->error_message ?? 'Unable to OCR the NID! Please try again later');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }
}
