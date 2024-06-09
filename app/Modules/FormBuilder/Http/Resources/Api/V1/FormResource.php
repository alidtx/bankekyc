<?php

namespace App\Modules\FormBuilder\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $this
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "partner_uid" => $this->partner_uid,
            "partner_name" => $this->partner->name ?? '',
            "name" => $this->name,
            "form_id" => $this->form_id,
            "action_url" => $this->action_url,
            "form_class" => $this->form_class,
            "parent_form_id" => $this->parent_form_id,
            "form_type_code" => $this->form_type_code,
            "form_type_title" => $this->form_types->title ?? '',
            "is_form_step_multiple" => $this->is_form_step_multiple,
            "is_layer_type_multiple" => $this->is_layer_type_multiple,
            "is_scoring_enable" => $this->is_scoring_enable,
            "score_type_uid" => $this->score_type_uid,
            "allowed_platform_type" => explode(',', $this->allowed_platform_type),
            "method" => $this->method,
            "status" => $this->status,
            "kyc_type"=> $this->kyc_type
        ];
    }
}
