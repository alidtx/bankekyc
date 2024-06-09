<?php

namespace App\Modules\FormBuilder\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Modules\FormBuilder\Http\Requests\Api\V1\FormsRequest;
use App\Modules\FormBuilder\Http\Resources\Api\V1\FormResource;
use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormField;
use App\Modules\FormBuilder\Models\FormType;
use App\Modules\FormBuilder\Models\FormRequest;
use App\Modules\FormBuilder\Models\FormInput;
use App\Modules\FormBuilder\Models\FormSection;
use App\Modules\FormBuilder\Services\Api\V1\ApplicationService;
use App\Traits\ApiResponseTrait;
use App\TransactionProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{

    use ApiResponseTrait;

    public $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Form[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
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
    public function store(FormsRequest $request)
    {
        try {
            $formStore = $this->formService->storeForm($request);
            if (gettype($formStore) === 'object') {
                return $this->successResponse('Form stored Successfully', $formStore);
            } else {
                return $this->exceptionResponse($formStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function generateRequestTrackingId(Request $request)
    {
        if (isset($request->user()->agent_id)) {
            $request->merge(['agent_uid' => $request->user()->agent_id]);
        }

        $validation = Validator::make($request->all(), [
            'form_id' => 'required|integer'
        ]);
        if ($validation->fails())
            return $this->invalidResponse($validation->errors()->first());
        try {
            $generateFormRequest = $this->applicationService->generateFormRequest($request);

            if (gettype($generateFormRequest) === 'object') {
                return $this->successResponse('Request tracking id generated Successfully', $generateFormRequest);
            } else {
                return $this->invalidResponse('Section validation failed', $generateFormRequest);
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function submit(Request $request)
    {
        return $this->formSubmit($request);
    }

    public function agentSubmit(Request $request)
    {
        if (isset($request->user()->agent_id)) {
            $request->merge(['agent_uid' => $request->user()->agent_id]);
            return $this->formSubmit($request);
        }
        return $this->invalidResponse('Agent key is missing');

        //        if (!$request->headers->get('agent-uid'))
        //            return $this->invalidResponse('Agent key is missing');
        //        $request->merge(['agent_uid' => $request->headers->get('agent-uid')]);
        //        return $this->formSubmit($request);
    }

    public function formSubmit(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'form_id' => 'required|integer',
            'request_tracking_uid' => 'required',
            'form_section' => 'required|array',
            'form_section.*.section_id' => 'required|integer',
            'form_section.*.section_field' => 'required|array',
            'form_section.*.section_field.*.field_id' => 'required|integer'
            //'form_section.*.section_field.*.field_value' => 'nullable'
        ]);
        if ($validation->fails())
            return $this->invalidResponse($validation->errors()->first());
        try {
            $storeFormRequest = $this->applicationService->storeFormRequest($request);

            if (gettype($storeFormRequest) === 'object') {
                return $this->successResponse('Request data stored Successfully', $storeFormRequest);
            } else {
                return $this->invalidResponse($storeFormRequest);
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    // To Do
    public function verifierSubmit($verifier, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'form_id' => 'required|integer',
            'request_tracking_uid' => 'required',
            'form_section' => 'required|array',
            'form_section.*.section_id' => 'required|integer',
            'form_section.*.section_field' => 'required|array',
            'form_section.*.section_field.*.field_id' => 'required|integer',
            'form_section.*.section_field.*.field_value' => 'required'
        ]);
        if ($validation->fails())
            return $this->invalidResponse($validation->errors()->first());
        try {
            $storeFormRequest = $this->applicationService->storeFormRequest($request, $verifier);

            if (gettype($storeFormRequest) === 'object') {
                return $this->successResponse('Request data stored Successfully', $storeFormRequest);
            } else {
                return $this->invalidResponse($storeFormRequest);
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function finalSubmit(Request $request)
    {
        if ($request->headers->get('request-tracking-uid')) {
            $request->merge(['request_tracking_uid' => $request->headers->get('request-tracking-uid')]);
        }
        $validation = Validator::make($request->all(), [
            'request_tracking_uid' => 'required'
        ]);
        if ($validation->fails())
            return $this->invalidResponse($validation->errors()->first());
        try {
            $getFormRequest = FormRequest::where('request_tracking_uid', $request->request_tracking_uid)->first();
            if (!$getFormRequest)
                return $this->invalidResponse('Please provide a valid request tracking uid');
            $form_id = $getFormRequest->form_id;
            $getInputFields = FormInput::where('form_request_id', $getFormRequest->id)->get();
            $checkValidation = $this->applicationService->checkSectionValidation(0, $getInputFields, $form_id);

            if (sizeof($checkValidation) == 0) {
                $getFormRequest->status = 'submitted';
                $getFormRequest->save();

                return $this->successResponse('Final submission has done Successfully', $getFormRequest);
            } else {
                return $this->invalidResponse($checkValidation);
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function verifierFinalSubmit($verifier, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'status' => 'required',
            'request_tracking_uid' => 'required'
        ]);
        if ($validation->fails())
            return $this->invalidResponse($validation->errors()->first());
        try {
            $getFormRequest = FormRequest::where('request_tracking_uid', $request->request_tracking_uid)->first();
            // if($verifier == 'checker'){
            //     $status = 'checked';
            // }elseif($verifier == 'approver'){
            //     $status = 'approved';
            // }

            if ($getFormRequest) {
                $getFormRequest->status = $request->status;
                $getFormRequest->save();

                return $this->successResponse('Final submission has done Successfully', $getFormRequest);
            } else {
                return $this->invalidResponse('Final submission failed');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function getApplication(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'request_tracking_uid' => 'required',
            'platform_type' => 'required'
        ]);
        if ($validation->fails())
            return $this->invalidResponse($validation->errors()->first());
        try {
            $getFormRequest = $this->applicationService->getApplicationByRequestId($request);
            if ($getFormRequest) {
                return $this->successResponse('Application details retirieved Successfully', $getFormRequest);
            } else {
                return $this->invalidResponse('Something went wrong. Please try again');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function mediaFiles($request)
    {
        //        
        //        $validation = Validator::make($request->all(), [
        //                    'form_id' => 'required|integer',
        //                    'request_tracking_uid' => 'required',
        //                    'form' => 'required|array',
        //                    'form.*.section_id' => 'required|integer',
        //                    'form.*.field_id' => 'required|integer',
        //                    'form.*.field_value' => 'required|file'
        //        ]);
        //        if ($validation->fails())
        //            return $this->invalidResponse($validation->errors()->first());
        //         
        try {

            $storeApplicationMedia = $this->applicationService->storeApplicationMedia($request);
            if ($storeApplicationMedia) {
                return $this->successResponse('Application media has submitted Successfully');
            } else {
                return $this->invalidResponse('Failed to upload media.');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!' . $ex);
        }
    }

    public function submitMediaFiles(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'form_id' => 'required|integer',
            'request_tracking_uid' => 'required',
            'form' => 'required|array',
            'form.*.section_id' => 'required|integer',
            'form.*.field_id' => 'required|integer',
            'form.*.field_value' => 'required|file'
        ]);
        if ($validation->fails())
            return $this->invalidResponse($validation->errors()->first());

        if (isset($request->verification_type)) {
            return $this->mediaFilesNID($request);
        } else {
            return $this->mediaFiles($request);
        }
    }

    public function test($x)
    {
        return $this->invalidResponse($x);
    }

    public function nomineeVerification(Request $request)
    {
        try {
            // Log::debug('enter in media-nid');
            // $config_data = [
            //     config('ekyc.nid_verification.nid_image'),
            //     config('ekyc.nid_verification.user_photo')
            // ];
            // $request_tracking = FormRequest::with('form_input')->where(['request_tracking_uid' => $request->request_tracking_uid, 'form_id' => $request->form_id])->first();
            // if (!$request_tracking || !$request_tracking->form_input) return $this->invalidResponse('Invalid request tracking UID');
            // $field_id_array = [];
            // foreach ($request->form as $form) {
            //     $field_id_array[] = $form['field_id'];
            // }
            // $form_fields = FormField::whereIn('id', $field_id_array)->get();
            // foreach ($form_fields as $form_field) {
            //     if (!in_array($form_field->field_name, $config_data)) {
            //         return $this->invalidResponse('Invalid form field id');
            //     }
            // }
            // $form_field0 = FormField::where(['id' => $request->form[0]['field_id'], 'form_id' => $request->form_id])->first();
            // $form_field1 = FormField::where(['id' => $request->form[1]['field_id'], 'form_id' => $request->form_id])->first();
            // if (!($form_field0 && $form_field0->field_name && ($form_field0->field_name == 'user_photo' || $form_field0->field_name == 'nid_image')))
            //     return $this->invalidResponse('1st form value is invalid');
            // if (!($form_field1 && $form_field1->field_name && ($form_field1->field_name == 'user_photo' || $form_field1->field_name == 'nid_image')))
            //     return $this->invalidResponse('2nd form value is invalid');
            // if ($form_field0->field_name == $form_field1->field_name)
            //     return $this->invalidResponse('Form one and two provide same value');
            // $request = $this->applicationService->storeApplicationMediaNID($request, $form_field0);
            $nominee_photo = FormField::where(['form_id' => $request->form_id, 'field_name' => 'nominee_photo'])->first();
            $nominee_photo_field_id = $nominee_photo->id;
            $nominee_nid = FormField::where(['form_id' => $request->form_id, 'field_name' => 'nominee_nid_front'])->first();
            $nominee_nid_field_id = $nominee_nid->id;


            $request_tracking = FormRequest::where(['request_tracking_uid' => $request->request_tracking_uid, 'form_id' => $request->form_id])->first();


            $photo_input = FormInput::where(['form_request_id' => $request_tracking->id, 'field_id' => $nominee_photo_field_id])->first();

            $nid_input = FormInput::where(['form_request_id' => $request_tracking->id, 'field_id' => $nominee_nid_field_id])->first();

            $nid_front_image_path = $nid_input->input_data;
            $selfie_image_path = $photo_input->input_data;

            // echo $nid_front_image_path.'**'.$selfie_image_path;
            // exit;

            Log::debug('enter in media-nid');

            $response = $this->guzzlePost(config('ekyc.api_base_url'), 'document-validation-and-details', [
                'json' => [
                    'nid_front_image_path' => $nid_front_image_path,
                    'request_type' => 'nid_detail_with_face_compare',
                    'selfie_image_path' => $selfie_image_path,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            ]);
            $response = \GuzzleHttp\json_decode($response->getBody());






            if ($response->status != 'success')
                return $this->invalidResponse($response->message[0] ?? 'Unable to retrieved the data');
            $config_data = config('ekyc.nominee_nid_verification');
            $prefilled_data = [];
            foreach ($config_data as $key => $field_name) {
                if ($field_name == 'nominee_nid_user_image')
                    continue;
                if (isset($response->data->{$key})) {
                    $form_field = FormField::where(['field_name' => $field_name, 'form_id' => $request->form_id])->first();
                    $prefilled_data[] = [
                        'title' => $field_name,
                        'name' => $form_field->label ?? ucwords(str_replace('_', ' ', $field_name)),
                        'value' => $response->data->{$key},
                    ];
                    if ($form_field) {
                        ApplicationController::saveFormInput($form_field->form_id, $form_field->id, $request_tracking->id, $response->data->{$key});
                    }
                }
            }
            return $this->successResponse('Successfully verification process done', [
                // "face_verification" => $response->data->face_verification,
                'nid_verification' => $response->data->nid_verification,
                'prefilled_data' => $prefilled_data
            ]);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function mediaFilesNID($request)
    {
        /*
          $validation = Validator::make($request->all(), [
          'form_id' => 'required|integer',
          'request_tracking_uid' => 'required',
          'form' => 'required|array',
          'form.*.section_id' => 'required|integer',
          'form.*.field_id' => 'required|integer',
          'form.*.field_value' => 'required|file'
          ]);
          if ($validation->fails())
          return $this->invalidResponse($validation->errors()->first());
         * 
         */

        try {
           
            switch ($request->verification_type) {
                case 'READ_NID_BASIC':
                    Log::debug('enter in media-nid asas');
                    //start dummy data code
                    // $config_data = config('ekyc.nid_verification');
                    // $prefilled_data = [];
                    // $responseData = [
                    //     "name" => "মোহাম্মদ আশফাক আলী",
                    //     "nameEn" => "Mohammod Ashfaque Ali",
                    //     "father" => "মোঃ নাসিম আলী ",
                    //     "mother" => "আফিয়া নাসিম",
                    //     "gender" => "male",
                    //     "spouse" => "ফারজানা করিম",
                    //     "dob" => "12/23/1991",
                    //     "permanentAddress" => "তেজগাঁও, গুলশান লিঙ্কক রোড, ঢাকা-১২০৮",
                    //     "presentAddress" => null,
                    //     "fatherEn" => "Md Nasim Ali",
                    //     "motherEn" => "Afia Nasim",
                    //     "spouseEn" => "Farjana Karim",
                    //     "permanentAddressEn" => "Tejgoan, Gulshan Link Road, Dhaka-1208",
                    // ];
                    // foreach ($config_data as $key => $field_name) {
                    //     // $form_field = FormField::where(['field_name' => $field_name, 'form_id' => $request->form_id])->first();
                    //     if (isset($responseData[$key]))
                    //         $prefilled_data[] = ['title' => $field_name, 'value' => $responseData[$key]];
                    // }
                    // return $this->successResponse('Successfully verification process done', [
                    //     "face_verification" => [
                    //         "status" => "VERIFIED",
                    //         "score" => "0.565544540"
                    //     ],
                    //     'nid_verification' => ['status' => 'VERIFIED'],
                    //     'prefilled_data' => $prefilled_data
                    // ]);
                    //end dummy data code
                    $config_data = [
                        config('ekyc.nid_verification.nid_image'),
                        config('ekyc.nid_verification.nid_image_back'),
                        config('ekyc.nid_verification.fingerprint'),
                        config('ekyc.nid_verification.user_photo')
                    ];
                    $request_tracking = FormRequest::with('form_input')->where(['request_tracking_uid' => $request->request_tracking_uid, 'form_id' => $request->form_id])->first();
                    if (!$request_tracking || !$request_tracking->form_input)
                        return $this->invalidResponse('Invalid request tracking UID');
                    $field_id_array = [];
                    foreach ($request->form as $form) {
                        $field_id_array[] = $form['field_id'];
                    }
                    $form_fields = FormField::whereIn('id', $field_id_array)->get();
                    foreach ($form_fields as $form_field) {
                        if (!in_array($form_field->field_name, $config_data)) {
                            return $this->invalidResponse('Invalid form field id');
                        }
                    }

                    $form_field0 = FormField::where(['id' => $request->form[0]['field_id'], 'form_id' => $request->form_id])->first();
                    $form_field1 = FormField::where(['id' => $request->form[1]['field_id'], 'form_id' => $request->form_id])->first();


                    if (!($form_field0 && $form_field0->field_name && ($form_field0->field_name == 'user_photo' || $form_field0->field_name == 'nid_image' || $form_field0->field_name == 'nid_image_back')))
                        return $this->invalidResponse('1st form value is invalid');

                    if (!($form_field1 && $form_field1->field_name && ($form_field1->field_name == 'user_photo' || $form_field1->field_name == 'nid_image' || $form_field1->field_name == 'nid_image_back')))
                        return $this->invalidResponse('2nd form value is invalid');

                    if ($form_field0->field_name == $form_field1->field_name)
                        return $this->invalidResponse('Form one and two provide same value');

                   
                    $request = $this->applicationService->storeApplicationMediaNID($request, $form_field0);
                   
                    $response = $this->guzzlePost(config('ekyc.api_base_url'), 'document-validation-and-details', [
                        'json' => [
                            'nid_front_image_path' => $request->nid_front_image,
                            'request_type' => 'nid_detail_with_face_compare',
                            'selfie_image_path' => $request->selfie_image,
                        ],
                        /*                        'multipart' => [
                          [
                          'name' => 'selfie_image',
                          'contents' => fopen($request->selfie_image, 'r'),
                          ],
                          [
                          'name' => 'id_front_image',
                          'contents' => fopen($request->nid_front_image, 'r'),
                          ],
                          [
                          'name' => 'request_type',
                          'contents' => 'nid_detail_with_face_compare'
                          ]
                          ], */
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ]
                    ]);
                    $response = \GuzzleHttp\json_decode($response->getBody(),true);
                   
                    //                    $response = json_decode(json_encode(['data' => [
                    //                        "name" => "মোঃ আব্দুল করিম",
                    //                        "nameEn" => "Md. Abdul Karim",
                    //                        "father" => "মোঃ আবুল হায়াত",
                    //                        "mother" => "রহিমা বানু",
                    //                        "gender" => "male",
                    //                        "spouse" => "ফারজানা করিম",
                    //                        "dob" => "10/20/1990",
                    //                        "permanentAddress" => "তেজগাঁও, গুলশান লিঙ্কক রোড, ঢাকা-১২০৮",
                    //                        "presentAddress" => null,
                    //                        "fatherEn" => "Md Abul Hayat",
                    //                        "motherEn" => "Rahima Banu",
                    //                        "spouseEn" => "Farjana Karim",
                    //                        "permanentAddressEn" => "Tejgoan, Gulshan Link Road, Dhaka-1208",
                    //                    ]]));
                    if ($response['status'] != 'success')
                    return $this->invalidResponse('Unable to retrieved the data');
                    $config_data = config('ekyc.nid_verification_upadated');
                    $prefilled_data = [];


                    $curl = curl_init();

                    $nid_img = base64_encode(file_get_contents(public_path($request->nid_front_image)));
                    $photo = base64_encode(file_get_contents(public_path($request->selfie_image)));
        
                    $postData = array(
                        "app_id" => 3,
                        "image_1" => $nid_img,
                        "image_2" => $photo,
                    );
                    
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://face-verification-nid.sslwireless.com/verify',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($postData),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));
                    
                    $imageCompareWithNid = curl_exec($curl);
        
                    Log::info("response".$imageCompareWithNid);
                    
                    if ($response === false) {
                        $error = curl_error($curl);
                        // Handle the cURL error
                    
                    }

                    $imageCompareWithNid = json_decode($imageCompareWithNid, true);

                    foreach ($config_data as $key => $field_name) {
                        if ($field_name == 'nid_user_image')
                            continue;
                        if (isset($response['data']['data'][$key])) {
                            $form_field = FormField::where(['field_name' => $field_name, 'form_id' => $request->form_id])->first();
                            $prefilled_data[] = [
                                'title' => $field_name,
                                'name' => $form_field->label ?? ucwords(str_replace('_', ' ', $field_name)),
                                'value' => $response['data']['data'][$key],
                            ];
                            if ($form_field) {
                                ApplicationController::saveFormInput($form_field->form_id, $form_field->id, $request_tracking->id, $response['data']['data'][$key],);
                            }
                        }
                    }
                    return $this->successResponse('Successfully verification process done', [
                        // "face_verification" => $response->data->face_verification,
                        'nid_verification' => ['status' => 'VERIFIED'],
                        'prefilled_data' => $prefilled_data,
                        'compare_response' => $response['data']['imageComapareService'],
                        'nid_response' => $response['data'],
                        'compare_image_with_nid' => $imageCompareWithNid['data']['result'],
                    ]);
                    break;
                case 'NID_OCR':
                    Log::debug('enter in media-nid for nid ocr');
                    $request_tracking = FormRequest::with('form_input')->where(['request_tracking_uid' => $request->request_tracking_uid, 'form_id' => $request->form_id])->first();
                    if (!$request_tracking || !$request_tracking->form_input)
                        return $this->invalidResponse('Invalid request tracking UID');


                    $form_field0 = FormField::where(['id' => $request->form[0]['field_id'], 'form_id' => $request->form_id])->first();
                    if ($form_field0 && $form_field0->field_name && ($form_field0->field_name == 'user_photo' || $form_field0->field_name == 'nid_image' || $form_field0->field_name == 'nid_image_back')) {
                        $get_section = 'main_user';
                        $photo_criteria = 'user_photo';
                        $nid_front_criteria = 'nid_image';
                        $nid_back_criteria = 'nid_image_back';
                        $config_data_parse = config('ekyc.nid_verification');
                        $config_data = [
                            config('ekyc.nid_verification.nid_image'),
                            config('ekyc.nid_verification.nid_image_back'),
                            config('ekyc.nid_verification.user_photo')
                        ];
                    } elseif ($form_field0 && $form_field0->field_name && ($form_field0->field_name == 'nominee_photo' || $form_field0->field_name == 'nominee_nid_front' || $form_field0->field_name == 'nominee_nid_back')) {
                        $get_section = 'nominee';
                        $photo_criteria = 'nominee_photo';
                        $nid_front_criteria = 'nominee_nid_front';
                        $nid_back_criteria = 'nominee_nid_back';
                        $config_data_parse = config('ekyc.nominee_nid_verification');
                        $config_data = [
                            config('ekyc.nominee_nid_verification.nid_image'),
                            config('ekyc.nominee_nid_verification.nid_image_back'),
                            config('ekyc.nominee_nid_verification.user_photo')
                        ];
                    } else {
                        $get_section = 'nominee2';
                        $photo_criteria = 'nominee2_photo';
                        $nid_front_criteria = 'nominee2_nid_front';
                        $nid_back_criteria = 'nominee2_nid_back';
                        $config_data_parse = config('ekyc.nominee2_nid_verification');
                        $config_data = [
                            config('ekyc.nominee2_nid_verification.nid_image'),
                            config('ekyc.nominee2_nid_verification.nid_image_back'),
                            config('ekyc.nominee2_nid_verification.user_photo')
                        ];
                    }

                    $field_id_array = [];
                    foreach ($request->form as $form) {
                        $field_id_array[] = $form['field_id'];
                    }
                    $form_fields = FormField::whereIn('id', $field_id_array)->get();
                    foreach ($form_fields as $form_field) {
                        if (!in_array($form_field->field_name, $config_data)) {
                            return $this->invalidResponse('Invalid form field id');
                        }
                    }

                    $form_field1 = FormField::where(['id' => $request->form[1]['field_id'], 'form_id' => $request->form_id])->first();

                    if (!($form_field0 && $form_field0->field_name && ($form_field0->field_name == $photo_criteria || $form_field0->field_name == $nid_front_criteria || $form_field0->field_name == $nid_back_criteria)))
                        return $this->invalidResponse('1st form value is invalid');

                    if (!($form_field1 && $form_field1->field_name && ($form_field1->field_name == $photo_criteria || $form_field1->field_name == $nid_front_criteria || $form_field1->field_name == $nid_back_criteria)))
                        return $this->invalidResponse('2nd form value is invalid');

                    if ($form_field0->field_name == $form_field1->field_name)
                        return $this->invalidResponse('Form one and two provide same value');

                    $request = $this->applicationService->storeApplicationMediaNID($request, $form_field0, $photo_criteria);
                    $response = $this->guzzlePost(config('ekyc.api_base_url'), 'document-validation-and-details', [
                        'json' => [
                            'nid_front_image_path' => $request->nid_front_image,
                            'request_type' => 'nid_ocr',
                            'selfie_image_path' => $request->selfie_image,
                        ],

                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ]
                    ]);
                    $response = \GuzzleHttp\json_decode($response->getBody());

                    if ($response->status != 'success')
                        return $this->invalidResponse($response->message[0] ?? 'Unable to retrieved the data');

                    $prefilled_data = [];
                    foreach ($config_data_parse as $key => $field_name) {
                        $key = $key == 'nid_number' ? 'nid' : $key; // just to keep consistancy with config data. need to fix later
                        if ($field_name == 'nid_user_image')
                            continue;
                        if (isset($response->data->{$key})) {
                            $form_field = FormField::where(['field_name' => $field_name, 'form_id' => $request->form_id])->first();
                            $prefilled_data[] = [
                                'title' => $field_name,
                                'name' => $form_field->label ?? ucwords(str_replace('_', ' ', $field_name)),
                                'value' => $response->data->{$key}
                            ];
                            if ($form_field) {
                                ApplicationController::saveFormInput($form_field->form_id, $form_field->id, $request_tracking->id, $response->data->{$key});
                            }
                        }
                    }
                    return $this->successResponse('Successfully verification process done', [
                        // "face_verification" => $response->data->face_verification,
                        'nid_verification' => null,
                        'prefilled_data' => $prefilled_data
                    ]);
                    break;
                default:
                    return $this->invalidResponse('Invalid verification type');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    private static function saveFormInput($form_id, $field_id, $form_request_id, $input_data, $mime_type = NULL)
    {
        $formInput = FormInput::where(
            [
                'form_id' => $form_id,
                'field_id' => $field_id,
                'form_request_id' => $form_request_id
            ]
        )->first();
        if ($formInput) {
            $formInput->update([
                'input_data' => $input_data,
                'mime_type' => $mime_type,
            ]);
        } else {
            $formInput = new FormInput;
            $formInput->form_id = $form_id;
            $formInput->field_id = $field_id;
            $formInput->form_request_id = $form_request_id;
            $formInput->input_data = $input_data;
            $formInput->mime_type = $mime_type;
            $formInput->save();
        }
    }

    public function viewApplication(Request $request)
    {
        $platform_type = $request->platform_type ?? '';
        $request_tracking_id = $request->tracking_id ?? '';
        $formRequest = FormRequest::where('request_tracking_uid', $request_tracking_id ?? '')->first();
        $result = $this->callGuzzle(config('ekyc.api_base_url'), 'application', ['request_tracking_uid' => $request_tracking_id, 'platform_type' => strtoupper($platform_type)], 'post');
        Log::debug('internal apisdsd hit for application details: ' . print_r($result, true));
        if ($result->code == 200) {
            $formDetails = $result->data->formInfo;
            /// Log::info($formDetails);
            $tp = TransactionProfile::first();
            $transactionPrfl = [];
            $transactionPrfl['name'] = "Transaction Profile";
            $transactionPrfl['form_section_fields'] = $tp;
            $formDetail['sec_one'][0] = $formDetails->form_section[4];
            $formDetail['sec_one'][1] = $formDetails->form_section[1];
            $formDetail['sec_one'][2] = $formDetails->form_section[6];
            $formDetail['sec_one'][3] = $formDetails->form_section[0];
            $formDetail['sec_two'][0] = $formDetails->form_section[5];

            if ($formDetails->form_section[2]->form_section_fields[2]->user_input_value != null) {
                $formDetail['sec_two'][1] = $formDetails->form_section[2];
            }
            if ($formDetails->form_section[3]->form_section_fields[2]->user_input_value != null) {
                $formDetail['sec_two'][2] = $formDetails->form_section[3];
            }

            $formDetail['sec_three'][0] = $transactionPrfl;
            $formDetail['sec_three'][1] = $formDetails->form_section[7];
            $formDetail['sec_three'][2] = $formDetails->form_section[8];
            $dependantForms = [];
            $getDependantForm = $this->callGuzzle(config('ekyc.api_base_url'), 'form/' . $formRequest->form_id . '/childs', [], 'get');
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

            return $this->successResponse('', [
                'formDetails' => $formDetail,
                'dependantForms' => $dependantForms,
                'formRequest' => $formRequest,

            ]);
        }

        return $this->invalidResponse('Something wrong.');
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


    public function addNewSectionForm(Request $request)
    {

        try {
            $form_id = $request->form_id ?? 8;
            $sectionId = $request->section_id ?? 47;
            $loadSection = FormSection::find($sectionId);

            if ($loadSection) {
                $fieldMapperData = $loadSection->field_mapper_data;
                $fieldMapperData =  json_decode($fieldMapperData, true);
                $formSection = new FormSection;
                $formSection->form_id = $form_id;
                $formSection->name = $loadSection->name ?? '';
                $formSection->section_id = $loadSection->section_id ?? '';
                $formSection->section_class = $loadSection->class ?? '';
                $formSection->section_type = 'both_form' ?? '';
                $formSection->sequence = $loadSection->sequence;
                $formSection->form_platform_type = "WEB";
                $formSection->is_show_on_tab = 0;
                $formSection->save();
                $sequence = 1;

                foreach ($fieldMapperData as $mappedData) {
                    $fieldId = $mappedData['field_id'];
                    $loadField = DB::table('form_fields')->where('id', $fieldId)->get()->toArray();
                    $newField = [];
                    foreach ($loadField as $key => $value) {
                        if ($value != '' && $value != NULL)
                            $newField[$key] = $value;
                    }
                    $newField[0]->field_name = $newField[0]->field_name . '_' . rand(10, 100);

                    $formField = new FormField;
                    $formField->form_id = $newField[0]->form_id;
                    $formField->field_name = $newField[0]->field_name ?? '';
                    $formField->field_type = $newField[0]->field_type ?? '';
                    $formField->data_type = $newField[0]->data_type ?? '';
                    $formField->label = $newField[0]->label ?? '';
                    $formField->placeholder = $newField[0]->placeholder ?? '';
                    $formField->field_default_value = $newField[0]->value ?? '';
                    $formField->min_length = $newField[0]->min ?? null;
                    $formField->max_length = $newField[0]->max ?? null;
                    $formField->pattern = $newField[0]->pattern ?? '';
                    $formField->custom_validation = $newField[0]->custom_validation ?? '';
                    $formField->is_required = $newField[0]->is_required ?? true;
                    $formField->is_readonly = $newField[0]->is_readonly ?? false;
                    $formField->is_disabled = $newField[0]->is_disable ?? false;
                    $formField->options = $newField[0]->options ?? null;
                    $formField->additional_attributes = $newField[0]->additional_attributes ?? null;
                    $formField->save();
                    $fieldMappeddData[] = [
                        'sequence' => $sequence,
                        'section_id' => $formSection->id,
                        'field_id' => $formField->id
                    ];

                    $sequence++;
                }
                $formSection =  FormSection::find($formSection->id);
                $formSection->field_mapper_data = json_encode($fieldMappeddData);
                $formSection->save();

                return $this->successResponse('New section and field created successfully.', [
                    'formSection' => $formSection,
                ]);
            }
            return $this->invalidResponse('Something wrong.');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }
}