<?php

namespace App\Modules\FormBuilder\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FormSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "form_id" => $this->form_id,
            "name" => $this->name,
            "form_platform_type" => $this->form_platform_type,
            "section_id" => $this->section_id,
            "section_class" => $this->section_class,
            "api_endpoint" => $this->api_endpoint,
            "should_validated" => $this->should_validated,
            "validation_api_url" => $this->validation_api_url,
            "carry_forward_data" => $this->carry_forward_data,
            "verification_type" => $this->verification_type,
            "section_type" => $this->section_type,
            "is_preview_on" => $this->is_preview_on,
            "can_go_previous_step" => $this->can_go_previous_step,
            "field_mapper_data" => json_decode($this->field_mapper_data),
            "sequence" => $this->sequence,
            "is_show_on_tab" => $this->is_show_on_tab
        ];
    }
}
