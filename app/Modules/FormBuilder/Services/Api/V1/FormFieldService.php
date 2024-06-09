<?php

namespace App\Modules\FormBuilder\Services\Api\V1;

use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormField;
use App\Modules\FormBuilder\Models\FormSection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FormFieldService {

    public function storeFormField(Request $request) {
        $formField = FormField::create($this->createUpdateDataPrepare($request));
//        $section = FormSection::find($request->section_id);
//        if (!$section->field_mapper_data) {
//            $section->update([
//                'field_mapper_data' => json_encode([$formField->id]),
//            ]);
//        } else {
//            $field_mapper_data = json_decode($section->field_mapper_data);
//            if (gettype($field_mapper_data) == 'array') {
//                $field_mapper_data[] = $formField->id;
//                $section->update([
//                    'field_mapper_data' => json_encode($field_mapper_data),
//                ]);
//            } else {
//                $section->update([
//                    'field_mapper_data' => json_encode([$formField->id]),
//                ]);
//            }
//        }
        return $formField ? $formField : 'Something went wrong! please try again later';
    }

    public function updateFormField(Request $request, int $id) {
        $formField = FormField::find($id)->update($this->createUpdateDataPrepare($request));
//        $formField = FormField::find($id);
//        $section = FormSection::find($request->section_id);
//        if (!$section->field_mapper_data) {
//            $section->update([
//                'field_mapper_data' => json_encode([$formField->id]),
//            ]);
//        } else {
//            $field_mapper_data = json_decode($section->field_mapper_data);
//            if (gettype($field_mapper_data) == 'array') {
//                if (!in_array($formField->id, $field_mapper_data)) {
//                    $section->update([
//                        'field_mapper_data' => json_encode($field_mapper_data),
//                    ]);
//                }
//            } else {
//                $section->update([
//                    'field_mapper_data' => json_encode([$formField->id]),
//                ]);
//            }
//        }
        if ($formField)
            return FormField::find($id);
        return 'Something went wrong! please try again later';
    }

    public function deleteFormField(int $id) {
        $formField = FormField::find($id);
//        $section = FormSection::where('form_id', $formField->form_id)->first();
//        if ($section->field_mapper_data) {
//            $field_mapper_data = json_decode($section->field_mapper_data);
//            if (gettype($field_mapper_data) == 'array') {
//                $key = array_search($formField->id, $field_mapper_data);
//                if ($key) {
//                    unset($field_mapper_data[$key]);
//                    $section->update([
//                        'field_mapper_data' => json_encode($field_mapper_data),
//                    ]);
//                }
//            }
//        }
        $delete = false;
        if ($formField)
            $delete = $formField->delete();
        return $delete ? $delete : 'Something went wrong! please Try again later';
    }

    public function mapSectionField(Request $request, $id) {
        $formField = FormField::find($id);
        if (!$formField)
            return 'Field not found';
        foreach ($request->field_mapper_data as $field_mapper_data) {
            if ($field_mapper_data['section_id']) {
                $section = FormSection::find($field_mapper_data['section_id']);

                if (isset($section->field_mapper_data)) {
                    $fmds = json_decode($section->field_mapper_data);
                    if (count($fmds) > 0) {
                        $flag = true;
                        foreach ($fmds as $key => $fmd) {
                            if ($fmd->field_id == $field_mapper_data['field_id']) {
                                $flag = false;
                                break;
                            }
                        }
                        if ($flag)
                            $fmds[] = $field_mapper_data;

                        $final = [];
                        foreach ($fmds as $current)
                            if (!in_array($current, $final))
                                $final[] = $current;
                        $section->update([
                            'field_mapper_data' => json_encode($final)
                        ]);
                    } else {
                        Log::info('110' . json_encode($fmds));
                        $section->update([
                            'field_mapper_data' => json_encode([$field_mapper_data])
                        ]);
                    }
                } else {
                    Log::info('116' . json_encode([$field_mapper_data]));
                    $section->update([
                        'field_mapper_data' => json_encode([$field_mapper_data])
                    ]);
                }
            } else {
                return 'data format miss match or section id missing';
            }
        }
        foreach ($request->field_mapper_data_delete as $field_mapper_data_delete) {
            if ($field_mapper_data_delete['section_id']) {
                $section = FormSection::find($field_mapper_data_delete['section_id']);
                if (isset($section->field_mapper_data)) {
                    $fmds = json_decode($section->field_mapper_data);
                    $deleteIndex = -1;
                    if (count($fmds) > 0) {
                        foreach ($fmds as $key => $fmd) {
                            if ($fmd->field_id == $field_mapper_data_delete['field_id']) {
                                $deleteIndex = $key;
                            }
                        }
                        if ($deleteIndex != -1) {
                            unset($fmds[$deleteIndex]);
                        }
                        $section->update([
                            'field_mapper_data' => json_encode($fmds)
                        ]);
                        Log::info('140' . json_encode($fmds));
                    } else {
//                        $section->update([
//                            'field_mapper_data' => json_encode([$field_mapper_data])
//                        ]);
                    }
                } else {
//                    $section->update([
//                        'field_mapper_data' => json_encode([$field_mapper_data])
//                    ]);
                }
            } else {
//                return 'data format miss match or section id missing';
            }
        }
        $formField = FormField::find($id);

        return $formField ? $formField : 'Form field date is missing';
    }

    private function createUpdateDataPrepare(Request $request) {
        return [
            'form_id' => $request->form_id,
            'field_type' => $request->field_type,
            'data_type' => $request->data_type,
            'label' => $request->label,
            'placeholder' => $request->placeholder,
            'field_name' => $request->field_name,
            'field_default_value' => $request->field_default_value,
            'min_length' => $request->min_length,
            'max_length' => $request->max_length,
            'pattern' => $request->pattern,
            'custom_validation' => $request->custom_validation,
            'additional_attributes' => json_encode($request->additional_attributes),
            'options' => json_encode($request->options),
            'is_required' => !!$request->is_required,
            'is_disabled' => !!$request->is_disabled,
            'is_readonly' => !!$request->is_readonly,
            'is_validation_required' => !!$request->is_validation_required,
            'validation_api_url' => $request->validation_api_url,
            'api_endpoint' => $request->api_endpoint,
            'file_source' => $request->file_source,
            'is_nid_verification' => $request->is_nid_verification,
            'is_score_mapping' => $request->is_score_mapping,
            'response_required_keys' => $request->response_required_keys,
//            $request->sections->map(function ($section) {
//                dd($section);
//            }),
        ];
    }

}
