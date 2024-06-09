<?php

namespace App\Modules\FormBuilder\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Modules\FormBuilder\Http\Requests\Api\V1\FormsRequest;
use App\Modules\FormBuilder\Http\Resources\Api\V1\FormResource;
use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormType;
use App\Modules\FormBuilder\Models\FormAccountType;
use App\Modules\FormBuilder\Services\Api\V1\FormService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FormController extends Controller {

    use ApiResponseTrait;

    public $formService;

    public function __construct(FormService $formService) {
        $this->formService = $formService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Form[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        try {
            if ($request->datatale == '1') {
                return DataTables::of(FormResource::collection(Form::all()))->make(true);
            }
            return $this->successResponse('Form Retrieved successfully', FormResource::collection(Form::with('form_section')->get() ?? []));
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function store(FormsRequest $request) {
        try {
            $formStore = $this->formService->storeForm($request);
            if (gettype($formStore) === 'object') {
                return $this->successResponse('Form stored Successfully', New FormResource($formStore));
            } else {
                return $this->exceptionResponse($formStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function update(FormsRequest $request, $id) {
        try {
            $formStore = $this->formService->updateForm($request, $id);
            if (gettype($formStore) === 'object') {
                return $this->successResponse('Form updated Successfully', New FormResource($formStore));
            } else {
                return $this->exceptionResponse($formStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        try {
            $formStore = $this->formService->deleteForm($id);
            if (gettype($formStore) === 'boolean') {
                return $this->successResponse('Form deleted Successfully', $formStore);
            } else {
                return $this->exceptionResponse($formStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function partners() {
        try {
            $partners = Partner::all();
            return $this->successResponse('Partners retrieved Successfully', $partners);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function formTypes() {
        try {
            $formType = FormAccountType::with(array('formType' => function($querySelect) {
                            $querySelect->select('id', 'account_type', 'type_code', 'title', 'icon', 'color', 'description', 'is_active')->where('is_active', 1);
                        }))
                    ->select("id", "account_type_title", "icon", "color")
                    ->where('is_active', 1)
                    ->get();
            return $this->successResponse('Form Type retrieved Successfully', $formType);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }
    
    public function formTypesAdmin()
    {
        try {
            $formType = FormType::select("title", "type_code")->get();
            return $this->successResponse('Form Type retrieved Successfully', $formType);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function formsByType($id) {
        try {
            $formsByType = FormType::with('form')->first();
            $forms = $this->formService->getFormTransformedData($formsByType->form ?? []);
            $data['formList'] = $forms;
            return $this->successResponse('Form data retrieved Successfully', $data);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function parentForms() {
        try {
            $parentForms = Form::select("name", "id")->get();
            return $this->successResponse('Parent Form retrieved Successfully', $parentForms);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function sections($id) {
        try {
            $formSection = $this->formService->getFormSections($id);
            if (gettype($formSection) === 'object') {
                return $this->successResponse('Form sections retrieved Successfully', $formSection);
            } else {
                return $this->exceptionResponse($formSection ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function details($form_id, Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'platform_type' => 'required'
            ]);
            if ($validation->fails())
                return $this->invalidResponse($validation->errors()->first());

            $formDetails = $this->formService->getFormDetails($form_id, $request->platform_type);

            if (gettype($formDetails) === 'array') {
                return $this->successResponse('FormSection deleted Successfully', $formDetails);
            } else {
                return $this->exceptionResponse($formDetails ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function getChildForms($parent_form_id) {
        try {

            $getChildFormsData = Form::where('parent_form_id', $parent_form_id)->get();
            $childForms = $this->formService->getFormTransformedData($getChildFormsData ?? []);

            return $this->successResponse('Dependant child forms retrieved Successfully', $childForms);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

}
