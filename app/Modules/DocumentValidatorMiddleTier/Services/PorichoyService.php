<?php


namespace App\Modules\DocumentValidatorMiddleTier\Services;
use App\Modules\DocumentValidatorMiddleTier\Http\Requests\NIDDetailRequest;
use App\Modules\DocumentValidatorMiddleTier\Models\IdCardDetailLog;
use App\Traits\ApiResponseTrait;
use App\Traits\GuzzleRequestTrait;
use Illuminate\Support\Facades\Log;

class PorichoyService
{
    use GuzzleRequestTrait, ApiResponseTrait;

    public function __construct()
    {
    }

    public function getNIDDetails(NIDDetailRequest $request)
    {
        try {

            $checkWithStoreData = $this->checkWithStoreData($request);
            if ($checkWithStoreData) return $checkWithStoreData;
            ini_set('memory_limit', -1);
            $response_Data = [
                'full_name' => $request->person_fullname,
                'dob' => $request->person_dob,
                'id_card_type' => 'nid',
                'id_card_no' => $request->national_id,
                'request_from_url' => '',
                'request_client_id' => ''
            ];
            $apptoken = config('ekyc.porichoy_api_token');
            // Log::debug('ptoken: ' . json_encode($apptoken));
            $auth_token = 'Bearer ' . $apptoken;
            $request_data = [
                'json' => [
                    'person_fullname' => $request->person_fullname,
                    'english_output' => true,
                    'person_dob' => $request->person_dob,
                    'national_id' => $request->national_id,
                    'match_name' => false
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $auth_token,
                    'Accept' => 'application/json',
                    'x-api-key' => $apptoken
                ]
            ];
            //  \Log::debug('request Data: ' . json_encode($request_data));

            $callPorichoy = $this->guzzlePost(config('ekyc.api_porichoy_url'), 'nid-person', $request_data);
            Log::info("erimon".$callPorichoy);
            $getNidConfirmation = \GuzzleHttp\json_decode($callPorichoy->getBody());
            \Log::debug('get porichoy response: ' . json_encode($getNidConfirmation));
            if ($getNidConfirmation->passKyc == 'yes' && $getNidConfirmation->errorCode == null) {
                //$response_Data['details'] = json_encode($getNidConfirmation->voter);
                $response_Data['status'] = 'success';
                $data = IDCardService::Store($response_Data);
                $data->nid_number = $request->national_id;
                return $this->successResponse('Successfully retrieved data', $data);
            } else {
                $response_Data['details'] = NULL;
                $response_Data['status'] = 'fail';
                $response_Data['fail_reason'] = 'Data miss match or server down';
                IDCardService::Store($response_Data);
                return $this->invalidResponse('Please provide the valid data and try again later');
            }

        } catch (\Exception $ex) {
            \Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }



    public function getNIDBasic(NIDDetailRequest $request)
    {
        try {
            $nid = str_replace(" ", "", $request->nid);
            $nid_length = strlen($nid);

            if ($nid_length == 10 || $nid_length == 13 || $nid_length == 17) {
                $getNid = IdCardDetailLog::where('id_card_no', $request->nid)->first();
                if ($getNid) {
                    return $this->successResponse('Successfully retrieved data', json_decode($getNid->details));
                }
                $apptoken = config('ekyc.porichoy_api_production_token');
                $auth_token = 'Bearer ' . $apptoken;
                $request_data = [
                    'json' => [
                        'person_fullname' => $request->full_name,
                        'english_output' => true,
                        'person_dob' => $request->dob,
                        'national_id' => $nid,
                        'match_name' => false
                    ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => $auth_token,
                        'Accept' => 'application/json',
                        'x-api-key' => $apptoken
                    ]
                ];
                $callPorichoy = $this->guzzlePost(config('ekyc.api_porichoy_url'), 'nid-person', $request_data);
                $getNidConfirmation = \GuzzleHttp\json_decode($callPorichoy->getBody());
                \Log::debug('get porichoy response for nid basic: ' . json_encode($getNidConfirmation));

                $response_Data['details'] = json_encode($getNidConfirmation);
                if (isset($getNidConfirmation->passKyc)) {
                    if ($getNidConfirmation->passKyc == 'yes' && $getNidConfirmation->errorCode == null) {
                        $response_Data['status'] = 'success';
                    } else {
                        $response_Data['status'] = 'fail';
                    }
                    $response_Data['id_card_type'] = 'nid';
                    $response_Data['id_card_no'] = $nid;
                    $response_Data['full_name'] = $request->full_name;
                    $response_Data['dob'] = $request->dob;
                    $response_Data['request_client_id'] = 'crm';
                    $data = IDCardService::Store($response_Data);
                    return $this->successResponse('Successfully retrieved data', $getNidConfirmation);
                } else {
                    return $this->invalidResponse($getNidConfirmation->message);
                }
            } else {
                return $this->invalidResponse('Nid must be 10, 13 or 17 digits');
            }
        } catch (\Exception $ex) {
            \Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    private function checkWithStoreData(NIDDetailRequest $request)
    {
        try {
            // $idcard_detail = IDCardService::Get($request->nid, 'nid', $request->dob, $request->full_name, 7); // upto 7 days check
            $idcard_detail = IDCardService::Get($request->nid, 'nid', $request->dob, $request->full_name);
            if ($idcard_detail && $idcard_detail->details) {
                // return $this->successResponse('Data retrieved successfully', json_decode($idcard_detail->details));
                $data = json_decode($idcard_detail->details);
                $data->nid_number = $idcard_detail->id_card_no;
                return $this->successResponse('Data retrieved successfully', $data);
            }

            return false;
        } catch (\Exception $ex) {
            \Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return false;
        }
    }
}
