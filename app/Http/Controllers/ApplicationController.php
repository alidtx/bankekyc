<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Modules\FormBuilder\Models\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    }

    public function viewApplication($platform_type, $request_tracking_id)
    {
        $formRequest = FormRequest::where('request_tracking_uid', $request_tracking_id ?? '')->first();
        $result = $this->callGuzzle(config('ekyc.api_base_url'), 'application', ['request_tracking_uid' => $request_tracking_id, 'platform_type' => strtoupper($platform_type)], 'post');

        Log::debug('internal api hit for application details: ' . print_r($result, true));

        if ($result->code == 200) {
            $formDetails = $result->data->formInfo;
            // $form_sections = $this->generateSectionAndFields($formDetails->form_section, $request_tracking_id);

            $dependantForms = [];
            $getDependantForm = $this->callGuzzle(config('ekyc.api_base_url'), 'form/' . $formRequest->form_id . '/childs', [], 'get');
            Log::debug('internal api hit for getting dependant form list: ' . print_r($getDependantForm, true));

            if ($getDependantForm->code == 200) {
                $dependantFormDetails = $getDependantForm->data;
                if (sizeof($dependantFormDetails) > 0) {
                    foreach ($dependantFormDetails as $key => $child) {
                        $getChildFormDetails = $this->callGuzzle(config('ekyc.api_base_url'), 'application', ['request_tracking_uid' => $request_tracking_id, 'platform_type' => strtoupper($platform_type)], 'post');

                        Log::debug('internal api hit for dependant application details: ' . print_r($getChildFormDetails, true));
                        if ($getChildFormDetails->code == 200) {
                            $childDetails = $getChildFormDetails->data->formInfo;

                            // $child_form_sections = $this->generateSectionAndFields($childDetails->form_section, $request_tracking_id);
                            $dependantForms[] = $childDetails;
                        }
                    }
                }
            }

            $getScorTypeUid = $formRequest->form->score_type_uid;
            $getQuestionnaire = $this->callGuzzle(config('ekyc.api_base_url'), 'scoring-questionnaire?score_type_uid=' . $getScorTypeUid, [], 'get');
            if ($getQuestionnaire->code == 200) {
                $getQuestionnaire = $getQuestionnaire->data->score_matrix[0];
            } else {
                $getQuestionnaire = [];
            }
        }

        return view('al-arafah.application', compact('formDetails', 'dependantForms', 'formRequest', 'getQuestionnaire', 'getScorTypeUid'));
    }

    public function generateSectionAndFields($form_sections, $request_tracking_id)
    {
        foreach ($form_sections as $key => $section) {
            $section_id = $section->id;
            // call retrieve application api

            $applicationData = $this->callGuzzle(config('ekyc.api_base_url'), 'application', ['request_tracking_uid' => $request_tracking_id, 'section_id' => $section_id], 'post');

            Log::debug('internal api hit to get application data: ' . print_r($applicationData, true));

            if ($applicationData->code == 200) {
                $i = 0;
                foreach ($section->form_section_fields as $formField) {
                    foreach ($applicationData->data->form_input as $key => $userInput) {
                        if ($formField->id == $userInput->field_id) {
                            $formField->user_input_value = $userInput->input_data;
                            $formField->mime_type = $userInput->mime_type;
                        }
                    }

                    $i++;
                }
            }
        }

        return $form_sections;
    }

    public function callGuzzle($base_url, $api, $data, $type, $is_json = false)
    {
        if ($type == 'post' && $is_json) {
            $request_data = [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ];
            $callApi = $this->guzzlePost($base_url, $api, $request_data);
        } elseif ($type == 'post') {
            $callApi = $this->guzzlePostCustom($base_url, $api, $data);
        } else {
            $callApi = $this->guzzleGet($base_url, $api, $data);
        }

        $getData = \GuzzleHttp\json_decode($callApi->getBody());
        return $getData;
    }

    public function submitCheckerApplication($form_id, Request $request)
    {
        $data['form_id'] = $form_id;
        $data['request_tracking_uid'] = $request_tracking_uid = $request->request_tracking_id;
        $i = 0;
        foreach ($request->section_ids as $sectionId) {
            $data['form_section'][$i]['section_id'] = $sectionId;
            $j = 0;
            foreach ($request->field_ids as $field_id) {
                $data['form_section'][$i]['section_field'][$j]['field_id'] = $field_id;
                $data['form_section'][$i]['section_field'][$j]['field_value'] = $request['field_value_' . $field_id];

                $j++;
            }

            $i++;
        }
        if (Auth::user()->can('Checker Management')) {
            $apiEndPoint = 'application/checker/submit';
            $FinalSubmitApiEndPoint = 'application/checker/submit/confirm';
        } elseif (Auth::user()->can('Approver Management')) {
            $apiEndPoint = 'application/approver/submit';
            $FinalSubmitApiEndPoint = 'application/approver/submit/confirm';
        } else {
            $apiEndPoint = '';
            $FinalSubmitApiEndPoint = '';
        }

        $submitApplication = $this->callGuzzle(config('ekyc.api_base_url'), $apiEndPoint, $data, 'post', true);

        if ($submitApplication->code == 200) {
            $message = 'Form submission has successfully done';
            if (isset($request->save)) {
                $finalSubmitApplication = $this->callGuzzle(config('ekyc.api_base_url'), $FinalSubmitApiEndPoint, ['request_tracking_uid' => $request_tracking_uid], 'post', true);
                if ($submitApplication->code == 200) {
                    $message = 'Final submission of the form has successfully done';
                }
            }
        }

        return redirect()->back()->with($message ?? 'Form submission has failed');
    }

    public function generateScore($request_tracking_uid, Request $request)
    {
        $getRequest = FormRequest::where('request_tracking_uid', $request_tracking_uid)->first();
        if ($getRequest) {
            $prepareData = [];
            $prepareData['score_type_uid'] = $request->score_type_uid;
            foreach ($request->all() as $key => $data) {
                if ('questions_' == substr($key, 0, 10)) {
                    $question_id = explode('_', $key)[1];
                    if ($request['options_' . $question_id] != null) {
                        $prepareData['questionnaires'][] =
                            [

                                "questionnaire_uid" => $data,
                                "options" => gettype($request['options_' . $question_id]) == 'string' ? [$request['options_' . $question_id]] : $request['options_' . $question_id]
                            ];
                    }
                }
            }
            $generateScore = $this->callGuzzle(config('ekyc.api_base_url'), 'score-generator', $prepareData, 'post', true);
            if ($generateScore->code != 200) return $this->invalidResponse($generateScore->message[0] ?? 'Score calculation failed');

            $getRequest->calculated_score = $generateScore->data->score;
            $getRequest->save();
        }
        $generatedScore['score'] = $generateScore->data->score;
        return $this->successResponse('Score Updated successfully', $generatedScore);
    }

    public function test()
    {


        $image =  base64_encode(file_get_contents(public_path($request->selfie_image_path)));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.161.191:5003/verify/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"nid_img" : "$image" , "photo" : "$image"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
