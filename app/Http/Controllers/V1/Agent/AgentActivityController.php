<?php

namespace App\Http\Controllers\V1\Agent;

use App\Http\Controllers\Controller;
use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormField;
use App\Modules\FormBuilder\Models\FormRequest;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgentActivityController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function applicationList(Request $request)
    {
        try {
            $status = $this->checkRoleWiseStatus($request);
            if (!$status) return $this->invalidResponse('Your are nor right person for this request');
            $applicationList = FormRequest::when($status != 'all', function ($q) use ($status) {
                $q->where('status', $status);
            })
                ->when($request->request_tracking_uid, function ($q) use ($request) {
                    $q->where('request_tracking_uid', $request->request_tracking_uid);
                })
                ->when($request->requested_via, function ($q) use ($request) {
                    $q->where('requested_via', $request->requested_via);
                })
                ->when($request->unique_key, function ($q) use ($request) {
                    $q->where('unique_key', $request->unique_key);
                })
                ->when($request->form_id, function ($q) use ($request) {
                    $q->where('form_id', $request->form_id);
                })
                ->when($request->agent_uid, function ($q) use ($request) {
                    $q->where('agent_uid', $request->agent_uid);
                })
                ->when($request->partner_uid, function ($q) use ($request) {
                    $q->where('partner_uid', $request->partner_uid);
                })
                ->when($request->from_date, function ($q) use ($request) {
                    $q->whereDate('updated_at', '>=', $request->from_date);
                })
                ->when($request->to_date, function ($q) use ($request) {
                    $q->whereDate('updated_at', '<=', $request->to_date);
                })
                ->with(['form_input', 'form', 'agent', 'form_input.form_field'])->orderBy('id', 'desc')->get()
                ->map(function ($formRequest) {
                    Log::info($formRequest);
                    $data = [];
                    foreach ($formRequest->form_input as $form_input) {

                        if($form_input->form_field){
                            $data[$form_input->form_field->field_name] = [
                                'value' => $form_input->input_data,
                                'title' => $form_input->form_field->label
                            ];
                        }
                      
                    }
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
                    $result['form_data'] = $data;
                    return $result;
                });
            return $this->successResponse('Data retrieved successfully', ['form_complete_value' => $applicationList]);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    private function checkRoleWiseStatus(Request $request)
    {
        if ($request->status === 'pending' && $request->role == 'checker') {
            return 'submitted';
        } else if ($request->status === 'pending' && $request->role == 'approver') {
            return 'checked';
        } else if ($request->status === 'approved' && $request->role == 'checker') {
            return 'checked';
        } else if ($request->status === 'approved' && $request->role == 'approver') {
            return 'approved';
        } else if ($request->status === 'declined' && $request->role == 'approver') {
            return 'declined';
        } else if ($request->role == 'admin') {
            return 'all';
        } else {
            return false;
        }
    }

}