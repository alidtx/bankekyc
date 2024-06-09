<?php

namespace App\Modules\FormBuilder\Http\Requests\Api\V1;

use App\Traits\RequestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormsRequest extends FormRequest
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
            'partner_uid' => 'nullable|string|exists:partners,partner_uid',
            'name' => 'required',
            'parent_form_id' => 'nullable|exists:forms,id',
            'form_type_code' => 'required|string|exists:form_types,type_code',
            'score_type_uid' => 'nullable|exists:score_types,score_type_uid',
        ];
    }
}
