<?php

namespace App\Modules\DocumentValidatorMiddletier\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OCRResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}