<?php

namespace App\Modules\FormBuilder\Services\Api\V1;

use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormSection;
use App\Modules\FormBuilder\Models\FormField;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormService {

    public function storeForm(Request $request) {
        $form = Form::create($this->processRequest($request));
        return $form ? $form : 'Something went wrong! please try again later';
    }

    public function updateForm(Request $request, int $id) {
        $form = Form::find($id);
        $form = $form->update($this->processRequest($request));
        if ($form)
            return Form::find($id);
        return 'Something went wrong! please try again later';
    }

    public function deleteForm(int $id) {
        $delete = Form::find($id);
        $childForm = Form::where('parent_form_id', $id)->get();
        if (count($childForm) > 0)
            Form::where('parent_form_id', $id)->delete();
        $delete = $delete->delete();
        return $delete ? $delete : 'Something went wrong! please Try again later';
    }

    public function getFormSections(int $id) {
        $formSections = FormSection::where('form_id', $id)->get();
        return $formSections ? $formSections : 'Something went wrong! please Try again later';
    }

    public function getFormDetails($form_id, $platform) {
        $formInfo = Form::with(['form_section' => function($query) use ($platform) {
                        $query->where('form_platform_type', $platform);
                    }])->where('id', $form_id)->first();

        $platforms = explode(",", $formInfo->allowed_platform_type);

        if (in_array(strtoupper($platform), $platforms)) {
            $formDetails = $this->__transformFormData($formInfo);
            $formDetails['form_section'] = $this->__transformFormSectionData($formInfo->form_section);

            return $formDetails ? $formDetails : 'Something went wrong! please Try again later';
        } else {
            return 'Invalid platform for this form. Please provide a valid platform';
        }
    }

    public function getFormTransformedData($formData) {
        if (sizeof($formData) > 0) {
            $i = 0;
            foreach ($formData as $form) {
                $data[$i]['id'] = $form->id;
                $data[$i]['partner_uid'] = $form->partner_uid;
                $data[$i]['name'] = $form->name;
                $data[$i]['form_attr_id'] = $form->form_id;
                $data[$i]['action_url'] = $form->action_url;
                $data[$i]['form_class'] = $form->form_class;
                $data[$i]['form_type_code'] = $form->form_type_code;
                $data[$i]['method'] = $form->method;
                $data[$i]['status'] = $form->status;
                $data[$i]['allowed_platform_type'] = explode(',', $form->allowed_platform_type);
                $i++;
            }
        }

        return $data ?? [];
    }

    private function __transformFormSectionData($formSection) {
        $data = [];
        if (sizeof($formSection) > 0) {
            $i = 0;
            foreach ($formSection as $section) {
                $data[$i]['id'] = $section->id;
                $data[$i]['form_id'] = $section->form_id;
                $data[$i]['name'] = $section->name;
                $data[$i]['form_platform_type'] = $section->form_platform_type;
                $data[$i]['section_attr_id'] = $section->section_id;
                $data[$i]['section_class'] = $section->section_class;
                $data[$i]['api_endpoint'] = $section->api_endpoint;
                $data[$i]['should_validated'] = $section->should_validated;
                $data[$i]['validation_api_url'] = $section->validation_api_url;
                $data[$i]['sequence'] = $section->sequence;
                $data[$i]['carry_forward_data'] = $section->carry_forward_data;
                $data[$i]['verification_type'] = $section->verification_type;
                $data[$i]['section_type'] = $section->section_type;
                $data[$i]['is_preview_on'] = $section->is_preview_on;
                $data[$i]['can_go_previous_step'] = $section->can_go_previous_step;
                $data[$i]['is_show_on_tab'] = $section->is_show_on_tab;
                $field_mapper = json_decode($section->field_mapper_data);
                if (sizeof($field_mapper) > 0) {

                    usort($field_mapper, function($a, $b) {
                        // return strcmp($a->sequence, $b->sequence);
                        return $a->sequence <=> $b->sequence;
                    });
                    // dd($field_mapper);
                    $data[$i]['form_section_fields'] = $this->__transformFormFieldData($field_mapper);
                } else {
                    $data[$i]['form_section_fields'] = [];
                }
                $i++;
            }
        }

        return $data;
    }

    private function __transformFormFieldData($field_data) {
        $i = 0;
        foreach ($field_data as $field) {
            $getField = FormField::find($field->field_id);
            if ($getField) {
                $data[$i]['id'] = $getField->id;
                $data[$i]['sequence'] = $field->sequence;
                $data[$i]['field_type'] = $getField->field_type;
                $data[$i]['data_type'] = $getField->data_type;
                $data[$i]['label'] = $getField->label;
                $data[$i]['placeholder'] = $getField->placeholder;
                $data[$i]['field_name'] = $getField->field_name;
                $data[$i]['field_default_value'] = $getField->field_default_value;
                $data[$i]['min_length'] = $getField->min_length;
                $data[$i]['max_length'] = $getField->max_length;
                $data[$i]['pattern'] = $getField->pattern;
                $data[$i]['custom_validation'] = $getField->custom_validation;
                $data[$i]['additional_attributes'] = json_decode($getField->additional_attributes);
                $data[$i]['api_endpoint'] = $getField->api_endpoint;
                $data[$i]['options'] = json_decode($getField->options);
                if ($getField->api_endpoint == "branch") {
                    $branches = DB::table('branches')->get()->toArray();
                    $branchArr = array();
                    foreach($branches as $branch){
                        $arr['key'] = $branch->code;
                        $arr['value'] = $branch->name;
                        $branchArr[] = $arr;
                    }
                    $data[$i]['options'] = $branchArr;
                }
                $data[$i]['is_required'] = $getField->is_required;
                $data[$i]['is_disabled'] = $getField->is_disabled;
                $data[$i]['is_readonly'] = $getField->is_readonly;
                $data[$i]['is_validation_required'] = $getField->is_validation_required;
                $data[$i]['is_nid_verification'] = $getField->is_nid_verification;
                $data[$i]['validation_api_url'] = $getField->validation_api_url;
                $data[$i]['response_required_keys'] = $getField->response_required_keys;
                $data[$i]['file_source'] = $getField->file_source;
                $i++;
            }
        }

        return $data;
    }

    private function __transformFormData($formData) {
        return [
            'id' => $formData->id,
            'partner_uid' => $formData->partner_uid,
            'name' => $formData->name,
            'form_attr_id' => $formData->form_attr_id,
            'action_url' => $formData->action_url,
            'form_class' => $formData->form_class,
            'form_type_title' => $formData->form_type_title,
            'method' => $formData->method,
            'is_form_step_multiple' => $formData->is_form_step_multiple,
            'is_layer_type_multiple' => $formData->is_layer_type_multiple,
            'is_scoring_enable' => $formData->is_scoring_enable,
            'status' => $formData->status
        ];
    }

    private function processRequest(Request $request) {
        return [
            'partner_uid' => $request->partner_uid,
            'name' => $request->name,
            'form_id' => $request->form_id,
            'action_url' => $request->action_url,
            'form_class' => $request->form_class,
            'parent_form_id' => $request->parent_form_id,
            'form_type_code' => $request->form_type_code,
            'is_form_step_multiple' => !!$request->is_form_step_multiple,
            'is_layer_type_multiple' => !!$request->is_layer_type_multiple,
            'is_scoring_enable' => !!$request->is_scoring_enable,
            'score_type_uid' => $request->score_type_uid,
            'allowed_platform_type' => implode(',', $request->allowed_platform_type),
            'method' => $request->input('method') ?? 'GET',
            'status' => !!$request->status,
            'kyc_type' =>$request->kyc_type
        ];
    }

}
