<?php

namespace App\Modules\User\Services;

use App\Traits\ApiResponseTrait;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Log;
use App\Modules\User\Models\Otp;
use App\Modules\User\Models\OtpLog;
use App\Modules\User\Models\ClientSession;
use Illuminate\Support\Facades\Hash;

class OtpService {

    use ApiResponseTrait;

    public function initiateOtp($mobileNo) {
        $generate = $this->checkOtpGenerate($mobileNo);
        if ($generate['generateFlag'] == 1) {
            $otp = new Otp;

            $chars = "123456789";
            $verificationCode = substr(str_shuffle($chars), 0, 6);
            $verificationCode = '123456'; // should comment in live
            $encryptedVerificationCode = Hash::make($verificationCode);
            $otp->encrypted_otp = $encryptedVerificationCode;
            $otp->mobile_no = $mobileNo;
            $otp->save();

            $otpLog = new OtpLog;
            $otpLog->encrypted_otp = $encryptedVerificationCode;
            $otpLog->mobile_no = $mobileNo;
            $otpLog->save();

            return array('isSuccess' => 1, 'message' => 'A verification code has been sent to your mobile', 'data' => array('otpCreatedAt' => $otp->created_at));
        }
        return array('isSuccess' => 1, 'message' => 'A verification code has already been sent to your mobile', 'data' => array('otpCreatedAt' => $generate['otpCreatedAt']));
    }

    private function checkOtpGenerate($mobileNo) {
        $otp = Otp::where('mobile_no', $mobileNo)->first();
        if (!$otp) { // no otp has created
            return array('generateFlag' => 1);
        }
        $nowTime = strtotime(date('Y-m-d H:i:s'));
        $otpCreationTime = strtotime($otp->created_at);
        if (($nowTime - $otpCreationTime) <= config('ekyc.otp_idle_time')) {
            return array('generateFlag' => 2, 'otpCreatedAt' => $otp->created_at);  // no otp will create
        }
        $otp->delete();
        return array('generateFlag' => 1);
    }

    public function validateOtp($mobileNo, $verificationCode) {
        $otp = Otp::where('mobile_no', $mobileNo)->first();
        if (!$otp) { // no otp has created
            return array('isSuccess' => 0, 'message' => 'No verification code has created yet', 'data' => null, 'code' => 'E001');
        }
        $nowTime = strtotime(date('Y-m-d H:i:s'));
        $otpCreationTime = strtotime($otp->created_at);
        $encrytedOtp = $otp->encrypted_otp;
        if (($nowTime - $otpCreationTime) <= config('ekyc.otp_idle_time')) {
            if (Hash::check($verificationCode, $encrytedOtp)) {
                $otp->delete();
                $sessionKey = md5($mobileNo . date('YmdHis') . uniqid());
                $clientSession = new ClientSession;
                $clientSession->mobile_no = $mobileNo;
                $clientSession->session_key = $sessionKey;
                $clientSession->save();

                return array('isSuccess' => 1, 'message' => 'Verification code has been matched', 'data' => array('client_session_key' => $sessionKey));
            } else {
                return array('isSuccess' => 0, 'message' => 'You have entered a wrong verification code', 'data' => null, 'code' => 'E002');
            }
        } else {
            $otp->delete();
            return array('isSuccess' => 0, 'message' => 'Time expired', 'data' => null, 'code' => 'E003'); // time expired
        }
    }

}
