<?php

namespace App\Modules\DocumentValidatorMiddleTier\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\DocumentValidatorMiddleTier\Http\Requests\NIDDetailRequest;
use App\Modules\DocumentValidatorMiddleTier\Services\GazeIDService;
use App\Modules\DocumentValidatorMiddleTier\Services\ImageCompareService;
use App\Modules\DocumentValidatorMiddleTier\Services\NIDService;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ThirdPartyAPIMiddleTierController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function getDocumentValidationAndDetails(Request $request)
    {
              
            

        try {
       
           Log::debug($request->request_type);
            $request = $this->fileMove($request);
            switch ($request->request_type) {
                case 'nid_detail_by_nid_data':
                    $porichoy = new PorichoyService();
                    return $porichoy->getNIDDetails(new NIDDetailRequest($request->all()));
                    break;
                case 'nid_detail_by_nid_image':
                    $gazeIDService = new GazeIDService();
                    $ocr_result = $gazeIDService->documentAINIDOCR($request);
                    //                    $ocr_result = $gazeIDService->gazeNIDOCR($request);
                    $ocr_result = $ocr_result->getData();
                    if (!isset($ocr_result) && (isset($ocr_result) && $ocr_result->status != 'success'))
                        return $this->invalidResponse($ocr_result->message[0] ?? 'OCR fail, Please provide a valid nid front image and try again later');
                    $porichoy = new PorichoyService();
                    return $porichoy->getNIDDetails(new NIDDetailRequest(
                        [
                            'english_output' => true,
                            'dob' => $ocr_result->data->dob,
                            'full_name' => $ocr_result->data->name,
                            'nid' => $ocr_result->data->nid
                        ]
                    ));
                    break;
                case 'face_compare_nid':
                    $gazeIDService = new GazeIDService();
                    return $gazeIDService->gazeCompareFace($request);
                    break;
                case 'nid_detail_with_face_compare':
                    $gazeIDService = new ImageCompareService();
                    $gazeCompareFace = $gazeIDService->gazeCompareFace($request);
                    $gazeCompareFace = $gazeCompareFace->getData();
                    Log::debug('gazaseCompareFace'.json_encode($gazeCompareFace));
                  
                    if ($gazeCompareFace->data == null) {
                        return $this->invalidResponse('NID Front / Back Quality Low');
                    }
                    
                    // return $this->successResponse('Successfully done validation', $gazeCompareFace->data->result);
                    // break;

                    //$gazeOCR = $gazeIDService->gazeCompareFace($request);

                    //                    $gazeOCR = $gazeIDService->gazeNIDOCR($request);
                    //$gazeOCR = $gazeOCR->getData();


                    // if ((!isset($gazeOCR) || $gazeOCR->status != 'success'))
                    //     return $this->invalidResponse($gazeOCR->message[0] ?? 'NID and selfie face did not match');

                    $porichoy = new NIDService();
                    $person_dob = strtotime($gazeCompareFace->data->result->key_word_dob);
                    $person_dob = date('Y-m-d', $person_dob);
                    $porichoyResponse = $porichoy->getNIDDetails(new NIDDetailRequest(
                        [
                            'english_output' => true,
                            'person_dob' => $person_dob,
                            'person_fullname' => $gazeCompareFace->data->result->key_word_name,
                            'national_id' => $gazeCompareFace->data->result->key_word_nid_no
                        ]
                    ));
                    Log::debug('Porichoy data porichoyResponse ' . print_r($porichoyResponse, true));
                    $porichoyResponse = $porichoyResponse->getData();
                    Log::debug('Porichoy data ' . print_r($porichoyResponse, true));
                    if ($porichoyResponse->status != 'success')
                        return $this->invalidResponse($porichoyResponse->message[0] ?? 'NID and selfie face did not match');
                    // $porichoyResponse->data->face_verification = $gazeCompareFace->data[0];
                    $porichoyResponse->data->nid_verification = ['status' => 'VERIFIED'];

                    // will eliminate for production
                    $porichoyResponse->data->name = $gazeCompareFace->data->result->key_word_name;
                    $porichoyResponse->data->dob = $person_dob;
                    $porichoyResponse->data->imageComapareService =  $gazeCompareFace->data->result;
                   
                    // elimination part ends
                    // elimination part ends
                   // Log::debug('Porichoy dasasata ' . print_r($porichoyResponse, true));
                    return $this->successResponse('Successfully done validation', $porichoyResponse->data);
                    break;
                case 'nid_ocr':
                    $GazeIDService = new GazeIDService();
                    return $GazeIDService->documentAINIDOCR($request);
                    //                    return $GazeIDService->gazeNIDOCR($request);
                    break;
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }



    public function checkNidStatus(NIDDetailRequest $request)
    {
        try {
            \Log::debug('request body for nid basic: ' . json_encode($request->all()));

            $porichoy = new PorichoyService();
            $porichoyResponse = $porichoy->getNIDBasic(new NIDDetailRequest($request->all()));
            $porichoyResponse = $porichoyResponse->getData();

            if ($porichoyResponse->status == 'success') {
                if ($porichoyResponse->data->passKyc == 'yes') {
                    return $this->successResponse('NID verification successfully done', $porichoyResponse->data);
                } else {
                    return $this->invalidResponse('Invalid Nid number or Date of Birth');
                }
            } else {
                return $this->invalidResponse($porichoyResponse->message[0]);
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function test_mrh(Request $request)
    {
        try {
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    private function fileMove(Request $request)
    {
        if ($file = $request->file('id_front_image')) {
            $filename_id_front_image = random_int(100000, 999999) . Carbon::now()->format('YmdHis') . str_replace(' ', '', $file->getClientOriginalName());
            $file->move(public_path('images/'), $filename_id_front_image);
            $filename_id_front_image = 'images/' . $filename_id_front_image;
            $request->merge(['nid_front_image_path' => $filename_id_front_image]);
        }
        if ($file = $request->file('selfie_image')) {
            $filename_selfie_image = random_int(100000, 999999) . Carbon::now()->format('YmdHis') . str_replace(' ', '', $file->getClientOriginalName());
            $file->move(public_path('images/'), $filename_selfie_image);
            $filename_selfie_image = 'images/' . $filename_selfie_image;
            $request->merge(['selfie_image_path' => $filename_selfie_image]);
        }
        if ($file = $request->file('nid_front_image')) {
            $filename_nid_front_image = random_int(100000, 999999) . Carbon::now()->format('YmdHis') . str_replace(' ', '', $file->getClientOriginalName());
            $file->move(public_path('images/'), $filename_nid_front_image);
            $filename_nid_front_image = 'images/' . $filename_nid_front_image;
            $request->merge(['nid_front_image_path' => $filename_nid_front_image]);
        }
        return $request;
    }
}