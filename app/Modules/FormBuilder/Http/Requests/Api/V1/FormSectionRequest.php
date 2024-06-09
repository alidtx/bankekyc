<?php

namespace App\Modules\FormBuilder\Http\Requests\Api\V1;

use App\Traits\RequestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class FormSectionRequest extends FormRequest
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
            'form_id' => 'required|exists:forms,id',
            'name' => 'required',
            'form_platform_type' => 'required',
            'sequence' => 'required|integer',
        ];
    }
}
