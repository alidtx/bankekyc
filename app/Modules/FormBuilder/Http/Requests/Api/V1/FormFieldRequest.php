<?php

namespace App\Modules\FormBuilder\Http\Requests\Api\V1;

use App\Traits\RequestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class FormFieldRequest extends FormRequest
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
            'field_type' => 'required',
            'label' => 'required',
            'field_name' => 'required',
            'option' => $this->data_type == 'select' ? 'required|array|min:1' : '',
        ];
    }
}
