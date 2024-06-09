<?php

namespace App\Modules\FormBuilder\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Modules\FormBuilder\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class FormSettingsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function accountType(Request $request) {
        try {
            return view('FormBuilder::admin.accountType', ['title' => 'Account Type', 'path' => ['Form'], 'route' => 'accountType']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            if ($request->ajax())
                return $this->exceptionResponse('Something went wrong!');
            abort(500);
        }
    }
    
     public function formType(Request $request) {
        try {
            return view('FormBuilder::admin.formType', ['title' => 'Form Type', 'path' => ['Form'], 'route' => 'formType']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            if ($request->ajax())
                return $this->exceptionResponse('Something went wrong!');
            abort(500);
        }
    }

}
