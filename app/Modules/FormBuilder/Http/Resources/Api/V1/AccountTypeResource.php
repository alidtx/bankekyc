<?php

namespace App\Modules\FormBuilder\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountTypeResource extends JsonResource
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
            "account_type_title" => $this->account_type_title,
            "account_type_sub_title" => $this->account_type_sub_title,
            "icon" => $this->icon,
            "color" => $this->color,
            "is_active" => $this->is_active
        ];
    }
}
