<?php

namespace App\Modules\DocumentValidatorMiddleTier\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestResponseTrait;

class NIDDetailRequest extends FormRequest
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
            'person_fullname' => 'required|string',
            'person_dob' => 'required|string',
            'national_id' => 'required|string',
        ];
    }
}
