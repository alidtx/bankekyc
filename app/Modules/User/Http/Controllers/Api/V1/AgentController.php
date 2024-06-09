<?php

namespace App\Modules\User\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\FormBuilder\Models\FormRequest;
use App\Modules\FormBuilder\Services\Api\V1\ApplicationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Agent;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponseTrait;

class AgentController extends Controller {

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     */
    use ApiResponseTrait;

    public $applicationService;

    public function __construct(ApplicationService $applicationService) {
        $this->applicationService = $applicationService;
    }

    public function login(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                    'remember_me' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $user = Agent::where('email', request()->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!Hash::check(request()->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // log the user in (needed for future requests)
        //Auth::login($user);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->user_id = $user->agent_id;
        $token->save();

        return $this->successResponse('Request tracking id generated Successfully', [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                    )->toDateTimeString()
        ]);
    }

    /**
     * Logout agent (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return $this->successResponse('Successfully logged out');
    }

    public function agentDetails(Request $request) {
        // $request->user()->token()->revoke();
        return $this->successResponse('Agent profile retrive succcessfully', array('name' => $request->user()->name,
                    'email' => $request->user()->email, 'mobile_no' => $request->user()->mobile_no, 'branch' => $request->user()->branchInfo->name,'address'=>$request->user()->address));
    }

    public function agentApplicationList(Request $request) {
        try {

            $agentUid = $request->user()->agent_id;
            $applicationList = FormRequest::whereNotIn('status', ['initiated'])
                    ->where('agent_uid', $agentUid)
                    ->with(['form_input', 'form', 'agent'])->orderby('created_at','desc')->get()  // 'form_input.form_field'
                    ->map(function ($formRequest) {
                $data = [];
//                foreach ($formRequest->form_input as $form_input) {
//                    $data[$form_input->form_field->field_name] = [
//                        'value' => $form_input->input_data,
//                        'title' => $form_input->form_field->label
//                    ];
//                }
                $result['application_start_date'] = Carbon::parse($formRequest->created_at)->format('Y-m-d H:i:s');
                $result['application_last_updated_date'] = Carbon::parse($formRequest->updated_at)->format('Y-m-d H:i:s');
                $result['request_tracking_uid'] = $formRequest->request_tracking_uid;
                $result['unique_key'] = $formRequest->unique_key;
                $result['status'] = $formRequest->status;
                $result['agent_name'] = $formRequest->agent->name ?? '';
                $result['requested_via'] = $formRequest->requested_via;
                $result['calculated_score'] = $formRequest->calculated_score;
                $result['form_name'] = $formRequest->form->name;
                $result['form_id'] = $formRequest->form->id;
                $result['form_type'] = $formRequest->form->form_types->title ?? '';
                $result['allowed_platform_type'] = $formRequest->form->allowed_platform_type ?? '';
                //$result['form_data'] = $data;
                return $result;
            });
            return $this->successResponse('Data retrieved successfully', ['form_complete_value' => $applicationList]);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function agentApplicationDetails(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'request_tracking_uid' => 'required',
                        'platform_type' => 'required'
            ]);
            if ($validation->fails())
                return $this->invalidResponse($validation->errors()->first());

            $getFormRequest = $this->applicationService->getApplicationByRequestId($request);
            if ($getFormRequest) {
                return $this->successResponse('Application details retirieved Successfully', $getFormRequest);
            } else {
                return $this->invalidResponse('Something went wrong. Please try again');
            }
        } catch (Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

}
