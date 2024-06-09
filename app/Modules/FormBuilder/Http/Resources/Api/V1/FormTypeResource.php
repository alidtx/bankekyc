<?php

namespace App\Modules\FormBuilder\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FormTypeResource extends JsonResource
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
            "account_type" => $this->account_type,
            "account_type_title"=> $this->accountType->account_type_title,
            "title" => $this->title,
            "type_code" => $this->type_code,
            "description" => $this->description,
            "icon" => $this->icon,
            "color" => $this->color,
            "is_active" => $this->is_active
        ];
    }
}
