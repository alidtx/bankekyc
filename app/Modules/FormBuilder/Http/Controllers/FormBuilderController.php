<?php

namespace App\Modules\FormBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\FormBuilder\Models\Form;
use App\Traits\GuzzleRequestTrait;
use Illuminate\Http\Request;

class FormBuilderController extends Controller
{
    use GuzzleRequestTrait;

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view("FormBuilder::welcome");
    }

    public function viewForm(Request $request, $id)
    {
        $endpoint = 'form/' . $id . '/details';
        $response = $this->guzzlePostCustom(config('ekyc.api_base_url'), $endpoint, ['platform_type' => 'web']);
        $result = \GuzzleHttp\json_decode($response->getBody());
        $formDetails = $result->data;
        return view("FormBuilder::admin.view_form", compact('formDetails'));
    }
}
