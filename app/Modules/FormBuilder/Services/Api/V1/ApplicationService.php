<?php

namespace App\Modules\FormBuilder\Services\Api\V1;

use DB;
use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormSection;
use App\Modules\FormBuilder\Models\FormField;
use App\Modules\FormBuilder\Models\FormRequest;
use App\Modules\FormBuilder\Models\FormInput;
use App\Modules\FormBuilder\Models\FormAuditLog;
use Carbon\Carbon;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ApplicationService
{

    use FileUpload;

    public function generateFormRequest(Request $request)
    {
        $form_id = $request->form_id;
        $form_info = Form::find($form_id);

        $formRequest = new FormRequest;
        $formRequest->request_tracking_uid = 'RQ' . $form_id . time();
        $formRequest->form_id = $form_id;
        $formRequest->partner_uid = $form_info->partner_uid;
        $formRequest->requested_via = $request->agent_uid ? 'agent' : 'customer';
        $formRequest->platform_type = $request->platform_type ?? 'web';
        $formRequest->agent_uid = $request->agent_uid;
        $formRequest->status = 'initiated';
        $formRequest->save();

        return $formRequest ? $formRequest : 'Something went wrong! please try again later';
    }

    public function storeFormRequest(Request $request, $verifier = '')
    {
        $form_id = $request->form_id;
        $form_info = Form::find($form_id);

        $formRequest = FormRequest::where('request_tracking_uid', $request->request_tracking_uid ?? '')->first();
        if (!$formRequest) {
            return ['Invalid request tracking id'];
        } else {
            $form_req_id = $formRequest->id;
            if ($verifier == '') {
                if ($formRequest->status != 'initiated') {
                    return ['This request has already submitted. You cant edit this request.'];
                }
            } elseif ($verifier == 'checker') {
                if ($formRequest->status != 'submitted') {
                    return ['This request has already submitted. You cant edit this request.'];
                }
            } elseif ($verifier == 'approver') {
                if ($formRequest->status != 'checked') {
                    return ['This request has already submitted. You cant edit this request.'];
                }
            }
        }

        Log::debug('get Form Section All info ' . print_r($request->form_section, true));
        foreach ($request->form_section as $key => $section) {
            $section_id = $section['section_id'];
            $getSection = FormSection::find($section_id);

            $checkValidation = $this->checkSectionValidation($getSection, $section['section_field'], $form_id);

            if (count($checkValidation) > 0) {
                return $checkValidation;
            }

            if ($getSection) {
                foreach ($section['section_field'] as $key => $field) {
                    if (!isset($field['field_value'])) {
                        continue;
                    }

                    $field_id = $field['field_id'];
                    $getField = FormField::find($field_id);
                    Log::debug('get field info ' . print_r($getField, true));
                    if ($getField) {
                        $formInput = FormInput::where(['form_request_id' => $form_req_id, 'field_id' => $field_id])->first();

                        if ($formInput) {
                            $oldInputValue = $formInput->input_data;
                            // to-do: update and insert into log table
                            if ($formInput->input_data != $field['field_value']) {
                                if ($form_info->kyc_type == 'regular' && $getField->is_score_mapping == 1) {

                                    // old and new value diye korte hobe
                                    $getOldScoreData = $this->scoreDataQuery($form_id, $field_id, $oldInputValue);
                                    if (sizeof($getOldScoreData) > 0) {
                                        $oldScore = $getOldScoreData[0]->score ?? 0;
                                    }

                                    $getNewScoreData = $this->scoreDataQuery($form_id, $field_id, $field['field_value']);
                                    if (sizeof($getNewScoreData) > 0) {
                                        $newScore = $getNewScoreData[0]->score ?? 0;
                                    }

                                    $formRequest->calculated_score = ($formRequest->calculated_score - $oldScore) + $newScore;
                                    $formRequest->save();
                                }

                                $formInput->input_data = $field['field_value'];
                                $formInput->save();

                                // insert into log table
                                $auditLog = new FormAuditLog;
                                $auditLog->form_id = $form_id;
                                $auditLog->form_request_id = $form_req_id;
                                $auditLog->field_id = $field_id;
                                $auditLog->old_value = $oldInputValue;
                                $auditLog->new_value = $field['field_value'];
                                // $auditLog->updated_by = 'customer'; // @to-do: customer, agent, checker, approver
                                $auditLog->save();
                            }
                        } else {
                            if ($form_info->kyc_type == 'regular' && $getField->is_score_mapping == 1) {
                                $getScoreData = $this->scoreDataQuery($form_id, $field_id, $field['field_value']);
                                if (sizeof($getScoreData) > 0) {
                                    $optionScore = $getScoreData[0]->score ?? 0;
                                    $formRequest->calculated_score = $formRequest->calculated_score  + $optionScore;
                                    $formRequest->save();
                                }
                            }

                            $formInput = new FormInput;
                            $formInput->form_id = $form_id;
                            // $formInput->section_id = $section_id;
                            $formInput->field_id = $field_id;
                            $formInput->form_request_id = $form_req_id;
                            $formInput->input_data = $field['field_value'];
                            $formInput->save();
                        }
                    }
                }
            }
        }

        return $formRequest ? $formRequest : 'Something went wrong! please try again later';
    }

    public function scoreDataQuery($form_id, $form_field_id, $form_field_value)
    {
        $score_option_data = DB::select("select ffq.*, ffqo.form_field_questionnaires_uid,ffqo.form_option_key, ffqo.questionnaire_option_id,
                    sqo.option_id, sqo.option_value, sqo.option_score as score
                    from form_field_questionnaires as ffq
                    right join form_field_questionnaire_options as ffqo on ffq.form_field_questionnaires_uid = ffqo.form_field_questionnaires_uid
                    right join score_questionnaire_options as sqo on ffqo.questionnaire_option_id = sqo.option_id
                    where ffq.form_id=" . $form_id . " and ffq.form_field_id=" . $form_field_id . " and ffqo.form_option_key like '" . $form_field_value . "'");

        // dd($score_option_data);
        return $score_option_data;
    }

    public function checkSectionValidation($section, $input_fields, $form_id)
    {
        return []; // For Emergency Issue fix
        $errors = [];
        if (is_int($section) && $section == 0) {
            $formFields = FormField::where('form_id', $form_id)->get();
        } else {
            $formFields = json_decode($section->field_mapper_data);
        }

       

        if (sizeof($formFields) > 0) {
            foreach ($formFields as $key => $formField) {
                $form_field_id = (is_int($section) && $section == 0) ? $formField->id : $formField->field_id;
                $getFieldInfo = (is_int($section) && $section == 0) ? $formField : FormField::find($formField->field_id);

                Log::debug('section ' . $section . ' form field id ' . $form_field_id . ' form field ' . print_r($formField, true));

                $checkRequired = -1;
                $inputValue = '';
                foreach ($input_fields as $key => $field) {
                    $inputFieldId = (is_int($section) && $section == 0) ? $field->field_id : $field['field_id'];
                    $userInputValue = "";
                    if (isset($field['field_value'])) {
                        $userInputValue = (is_int($section) && $section == 0) ? $field->input_data : $field['field_value'];
                    }

                    if ($form_field_id == $inputFieldId) {
                        $checkRequired = $key;
                        $inputValue = $userInputValue;
                    }
                }

                Log::debug('get field info ' . print_r($getFieldInfo, true));

                if ($getFieldInfo->data_type != 'file' && $getFieldInfo->is_required && $checkRequired == -1 && !$inputValue) {
                    $errors[] = 'The field ' . $getFieldInfo->label . ' is required';
                }

                if ($checkRequired == -1)
                    continue;

                if ($getFieldInfo->data_type == 'number') {
                    if (!!$getFieldInfo->min_length) {
                        if ($inputValue < $getFieldInfo->min_length) {
                            $errors[] = 'The field ' . $getFieldInfo->label . ' is less than its minimum length';
                        }
                    }
                    if (!!$getFieldInfo->max_length) {
                        if ($inputValue > $getFieldInfo->max_length) {
                            $errors[] = 'The field ' . $getFieldInfo->label . ' is exceeding its maximum length';
                        }
                    }
                    // $errors[] = 'The field ' . $getFieldInfo->label . ' is required';
                }

                if ($getFieldInfo->data_type == 'input' || $getFieldInfo->data_type == 'textarea') {
                    if (!!$getFieldInfo->min_length) {
                        if (strlen($inputValue) < $getFieldInfo->min_length) {
                            $errors[] = 'The field ' . $getFieldInfo->label . ' is less than its minimum length';
                        }
                    }
                    if (!!$getFieldInfo->max_length) {
                        if (strlen($inputValue) > $getFieldInfo->max_length) {
                            $errors[] = 'The field ' . $getFieldInfo->label . ' is exceeding its maximum length';
                        }
                    }
                    // $errors[] = 'The field ' . $getFieldInfo->label . ' is required';
                }
            }
        }
        return $errors;
    }

    public function getApplicationByRequestId(Request $request)
    {
        $platform = strtoupper($request->platform_type);
        $getFormRequest = FormRequest::with(['form', 'form.form_section' => function ($query) use ($platform) {
            $query->where('form_platform_type', $platform);
        }])->where('request_tracking_uid', $request->request_tracking_uid)->first();
        // dd($getFormRequest);
        if ($getFormRequest) {
            $formRequestDetails = $this->__transformFormData($getFormRequest);

            return $formRequestDetails;
        }
        return false;
    }

    private function __transformFormData($formRequestData)
    {
        $transformData['id'] = $formRequestData->id;
        $transformData['request_tracking_uid'] = $formRequestData->request_tracking_uid;
        $transformData['status'] = $formRequestData->status;
        $transformData['requested_via'] = $formRequestData->requested_via;
        $transformData['agent_uid'] = $formRequestData->agent_uid;
        $transformData['calculated_score'] = $formRequestData->calculated_score;
        $transformData['formInfo']['id'] = $formRequestData->form->id;
        $transformData['formInfo']['partner_uid'] = $formRequestData->form->partner_uid;
        $transformData['formInfo']['name'] = $formRequestData->form->name;
        $transformData['formInfo']['form_type_code'] = $formRequestData->form->form_type_code;
        $transformData['formInfo']['method'] = $formRequestData->form->method;
        $transformData['formInfo']['action_url'] = $formRequestData->form->action_url;

        $transformData['formInfo']['form_section'] = $this->__transformFormSectionData($formRequestData->form->form_section, $formRequestData->id);

        return $transformData;
    }

    private function __transformFormSectionData($formSection, $request_tracking_id)
    {
        $data = [];
        if (sizeof($formSection) > 0) {
            $i = 0;
            foreach ($formSection as $section) {
                $data[$i]['id'] = $section->id;
                // $data[$i]['form_id'] = $section->form_id;
                $data[$i]['name'] = $section->name;
                $data[$i]['form_platform_type'] = $section->form_platform_type;
                $data[$i]['sequence'] = $section->sequence;
                $field_mapper = json_decode($section->field_mapper_data);
                if (sizeof($field_mapper) > 0) {
                    usort($field_mapper, function ($a, $b) {
                        return strcmp($a->sequence, $b->sequence);
                    });
                    // dd($field_mapper);
                    $data[$i]['form_section_fields'] = $this->__transformFormFieldData($field_mapper, $request_tracking_id);
                } else {
                    $data[$i]['form_section_fields'] = [];
                }
                $i++;
            }
        }

        return $data;
    }

    private function __transformFormFieldData($field_data, $request_tracking_id)
    {
        $i = 0;
        foreach ($field_data as $field) {
            $getField = FormField::find($field->field_id);
            if ($getField) {
                $getInputValue = FormInput::where(['field_id' => $getField->id, 'form_id' => $getField->form_id, 'form_request_id' => $request_tracking_id])->first();

                $data[$i]['id'] = $getField->id;
                $data[$i]['sequence'] = $field->sequence;
                $data[$i]['field_type'] = $getField->field_type;
                $data[$i]['data_type'] = $getField->data_type;
                $data[$i]['label'] = $getField->label;
                $data[$i]['min_length'] = $getField->min_length;
                $data[$i]['max_length'] = $getField->max_length;
                $data[$i]['is_required'] = $getField->is_required;
                $data[$i]['field_default_value'] = $getField->field_default_value;
                $data[$i]['user_input_value'] = $getInputValue->input_data ?? '';
                $data[$i]['mime_type'] = $getInputValue->mime_type ?? '';
                $i++;
            }
        }

        return $data;
    }

    public function storeApplicationMedia(Request $request)
    {
        $getFormRequest = FormRequest::where('request_tracking_uid', $request->request_tracking_uid)->first();
        $form_id = $request->form_id;
        foreach ($request->form as $key => $form) {
            $file = $form['field_value'];
            $filename = str_replace(' ', '', $file->getClientOriginalName());
            $mime_type = $file->getMimeType();
            $destinationFolder = 'user_documents/' . date('Y-m-d');
            $uploadFile = $this->saveFile($destinationFolder, $file, $filename);
            if ($uploadFile) {
                $form_input = FormInput::where(['form_id' => $form_id, 'field_id' => $form['field_id'], 'form_request_id' => $getFormRequest->id,])->first();
                if ($form_input) {
                    $form_input->update([
                        'input_data' => $uploadFile,
                        'mime_type' => $mime_type,
                    ]);
                } else {
                    $formInput = new FormInput;
                    $formInput->form_id = $form_id;
                    // $formInput->section_id = $form['section_id'];
                    $formInput->field_id = $form['field_id'];
                    $formInput->form_request_id = $getFormRequest->id;
                    $formInput->input_data = $uploadFile;
                    $formInput->mime_type = $mime_type;
                    $formInput->save();
                }
            }
        }

        return true;
    }

    public function storeApplicationMediaNID(Request $request, $form_field0, $photo_criteria = null)
    {

        // $getPhotoCriteria = $photo_criteria == null ? 'user_photo' : $photo_criteria;
        // if ($form_field0->field_name == $getPhotoCriteria) {
        //     $image_name1 = 'selfie_image';
        //     $image_name2 = 'nid_front_image';
        // } else {
        //     $image_name2 = 'selfie_image';
        //     $image_name1 = 'nid_front_image';
        // }
        $getFormRequest = FormRequest::where('request_tracking_uid', $request->request_tracking_uid)->first();
        $form_id = $request->form_id;
        $now = time();
        foreach ($request->form as $key => $form) {
            $file = $form['field_value'];
            $filename = str_replace(' ', '', $now . '_' . $file->getClientOriginalName());
            $mime_type = $file->getMimeType();
            $destinationFolder = 'user_documents/' . date('Y-m-d');

            $uploadFile = $this->saveFile($destinationFolder, $file, $filename);
            $getFieldInfo = FormField::where(['id' => $form['field_id'], 'form_id' => $form_id])->first();
            if ($getFieldInfo->field_name == 'user_photo' || $getFieldInfo->field_name == 'nominee_photo' || $getFieldInfo->field_name == 'nominee2_photo') {
                $request->merge(['selfie_image' => $uploadFile]);
            }
            if ($getFieldInfo->field_name == 'nid_image' || $getFieldInfo->field_name == 'nominee_nid_front' || $getFieldInfo->field_name == 'nominee2_nid_front') {
                $request->merge(['nid_front_image' => $uploadFile]);
            }

            // if ($key != 2 || $key != 3) // static condition. skip for third and fourth image which is nid back and fingerprint image
            //     $key === 0 ? $request->merge([$image_name1 => $uploadFile]) : $request->merge([$image_name2 => $uploadFile]);

            if ($uploadFile) {

                $formInput = FormInput::where(['form_request_id' => $getFormRequest->id, 'field_id' => $form['field_id']])->first();

                if ($formInput) {
                    $oldInputValue = $formInput->input_data;
                    // to-do: update and insert into log table
                    if ($formInput->input_data != $uploadFile) {
                        $formInput->input_data = $uploadFile;
                        $formInput->mime_type = $mime_type;
                        $formInput->save();

                        // insert into log table
                        $auditLog = new FormAuditLog;
                        $auditLog->form_id = $form_id;
                        $auditLog->form_request_id = $getFormRequest->id;
                        $auditLog->field_id = $form['field_id'];
                        $auditLog->old_value = $oldInputValue;
                        $auditLog->new_value = $uploadFile;
                        // $auditLog->updated_by = 'customer'; // @to-do: customer, agent, checker, approver
                        $auditLog->save();
                    }
                } else {
                    $formInput = new FormInput;
                    $formInput->form_id = $form_id;
                    // $formInput->section_id = $form['section_id'];
                    $formInput->field_id = $form['field_id'];
                    $formInput->form_request_id = $getFormRequest->id;
                    $formInput->input_data = $uploadFile;
                    $formInput->mime_type = $mime_type;
                    $formInput->save();
                }
            }
        }
        return $request;
    }
}