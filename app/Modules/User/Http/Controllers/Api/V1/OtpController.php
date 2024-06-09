<?php

namespace App\Modules\User\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Modules\User\Services\OtpService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller {

    use ApiResponseTrait;

    public function __construct() {
        
    }

    public function generateOtp(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'mobile_no' => 'required|digits_between:11,11|numeric'
            ]);
            if ($validation->fails()) {
                return $this->invalidResponse($validation->errors()->first());
            }
            $otpService = new OtpService();
            $response = $otpService->initiateOtp(trim($request->input('mobile_no')));
            if ($response['isSuccess'] == 1) {
                return $this->successResponse($response['message'], $response['data']);
            }
            return $this->invalidResponse('Something went wrong');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function verifyOtp(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'mobile_no' => 'required|digits_between:11,11|numeric',
                        'verification_code' => 'required|digits_between:6,6|numeric'
            ]);
            if ($validation->fails()) {
                return $this->invalidResponse($validation->errors()->first());
            }
            $otpService = new OtpService();
            $response = $otpService->validateOtp(trim($request->input('mobile_no')), trim($request->input('verification_code')));
            if ($response['isSuccess'] == 1) {
                return $this->successResponse($response['message'], $response['data']);
            }
            return $this->invalidResponse($response['message'], $response['data'], $response['code']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

}
