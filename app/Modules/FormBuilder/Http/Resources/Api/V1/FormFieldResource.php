<?php

namespace App\Modules\FormBuilder\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FormFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $id = $this->id;
        $sections = [];
        if($this->sections != null){
            foreach ($this->sections as $section) {
                if ($section->field_mapper_data == null) continue;
                $section_mapper = json_decode($section->field_mapper_data);
                foreach ($section_mapper as $field_mapper) {
                    if ($field_mapper->field_id === $id) {
                        $sections[] = $field_mapper;
                    }
                }
            }
        }
        return
            [
                'id' => $this->id,
                'form_id' => $this->form_id,
                'field_type' => $this->field_type,
                'data_type' => $this->data_type,
                'label' => $this->label,
                'placeholder' => $this->placeholder,
                'field_name' => $this->field_name,
                'field_default_value' => $this->field_default_value,
                'min_length' => $this->min_length,
                'max_length' => $this->max_length,
                'pattern' => $this->pattern,
                'custom_validation' => $this->custom_validation,
                'additional_attributes' => json_decode($this->additional_attributes),
                'options' => json_decode($this->options),
                'is_required' => $this->is_required,
                'is_disabled' => $this->is_disabled,
                'is_readonly' => $this->is_readonly,
                'sequence' => $this->sequence,
                'is_validation_required' => $this->is_validation_required,
                'validation_api_url' => $this->validation_api_url,
                'api_endpoint' => $this->api_endpoint,
                'is_nid_verification' => $this->is_nid_verification,
                'is_score_mapping' => $this->is_score_mapping,
                'response_required_keys' => $this->response_required_keys,
                'file_source' => $this->file_source,
                'sections' => $sections
            ];
    }
}
