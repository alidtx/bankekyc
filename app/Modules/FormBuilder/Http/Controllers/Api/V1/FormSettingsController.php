<?php

namespace App\Modules\FormBuilder\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\FormBuilder\Http\Resources\Api\V1\AccountTypeResource;
use App\Modules\FormBuilder\Http\Resources\Api\V1\FormTypeResource;
use App\Modules\FormBuilder\Models\FormAccountType;
use App\Modules\FormBuilder\Models\FormType;
use App\Modules\FormBuilder\Services\Api\V1\FormSettingsService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FormSettingsController extends Controller {

    use ApiResponseTrait;

    public function __construct() {
        
    }

    public function getAccountType(Request $request) {
        try {
            if ($request->datatale == '1') {
                return DataTables::of(AccountTypeResource::collection(FormAccountType::all()))->make(true);
            }
            //return $this->successResponse('Account Types Retrieved successfully', FormResource::collection(Form::with('form_section')->get() ?? []));
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function addAccountType(Request $request) {
        try {
            $formSettingsService = new FormSettingsService();
            $accountType = $formSettingsService->storeAccountType($request);
            if (gettype($accountType) === 'object') {
                return $this->successResponse('Account type stored Successfully', New AccountTypeResource($accountType));
            } else {
                return $this->exceptionResponse($accountType ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function editAccountType(Request $request) {
        //return $this->successResponse('Account type updated Successfully', $request->all());
        try {
            $formSettingsService = new FormSettingsService();
            $accountType = $formSettingsService->updateAccountType($request);
            if (gettype($accountType) === 'object') {
                return $this->successResponse('Account type updated Successfully', New AccountTypeResource($accountType));
            } else {
                return $this->exceptionResponse($accountType ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function statusChangeAccountType(Request $request) {
        //return $this->successResponse('Account type updated Successfully', $request->all());
        try {
            $formSettingsService = new FormSettingsService();
            $accountType = $formSettingsService->changeStatusAccountType($request);
            if (gettype($accountType) === 'object') {
                return $this->successResponse('Account status updated Successfully', New AccountTypeResource($accountType));
            } else {
                return $this->exceptionResponse($accountType ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function getFormType(Request $request) {
//        $x = DataTables::of(FormTypeResource::collection(FormType::with('accountType')->get()))->make(true);
//        echo "<pre>";
//        print_r($x);
//        exit();
//        $x = FormType::with('accountType')->get()->toArray();
//        dd($x);
        try {
            if ($request->datatale == '1') {
                return DataTables::of(FormTypeResource::collection(FormType::with('accountType')->get()))->make(true);
            }
            //return $this->successResponse('Account Types Retrieved successfully', FormResource::collection(Form::with('form_section')->get() ?? []));
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function accountType() {
        try {
            $formType = FormAccountType::select("id", "account_type_title")->get();
            return $this->successResponse('Account Type retrieved Successfully', $formType);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function addFormType(Request $request) {
        try {
            $formSettingsService = new FormSettingsService();
            $formType = $formSettingsService->storeFormType($request);
            if (gettype($formType) === 'object') {
                return $this->successResponse('Form type stored Successfully', New FormTypeResource($formType));
            } else {
                return $this->exceptionResponse($formType ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function editFormType(Request $request) {
//        return $this->successResponse('Account type updated Successfully', $request->all());
        try {
            $formSettingsService = new FormSettingsService();
            $formType = $formSettingsService->updateFormType($request);
            if (gettype($formType) === 'object') {
                return $this->successResponse('Form type updated Successfully', New FormTypeResource($formType));
            } else {
                return $this->exceptionResponse($formType ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

}
