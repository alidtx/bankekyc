<?php

namespace App\Modules\FormBuilder\Http\Requests\Api\V1;

use App\Traits\RequestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class MapperRequest extends FormRequest
{
    use RequestResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'field_mapper_data' => 'required|array',
            'field_mapper_data.*.field_id' => 'required',
            'field_mapper_data.*.section_id' => 'required',
            'field_mapper_data.*.sequence' => 'required',
        ];
    }
}
