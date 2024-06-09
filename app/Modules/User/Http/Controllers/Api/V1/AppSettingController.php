<?php

namespace App\Modules\User\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Modules\User\Models\AppSetting;

class AppSettingController extends Controller {

    use ApiResponseTrait;

    public function __construct() {
        
    }

    public function getSettingDetails() {
        try {
            $response['data'] = AppSetting::first();
            return $this->successResponse("Setting data fetch successfully", $response['data']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

}
