<?php

namespace App\Modules\FormBuilder\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\FormBuilder\Http\Requests\Api\V1\FormFieldRequest;
use App\Modules\FormBuilder\Http\Requests\Api\V1\MapperRequest;
use App\Modules\FormBuilder\Http\Resources\Api\V1\FormFieldResource;
use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormField;
use App\Modules\FormBuilder\Models\FormSection;
use App\Modules\FormBuilder\Services\Api\V1\FormFieldService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class FormFieldController extends Controller
{
    use ApiResponseTrait;

    public $formFieldService;

    public function __construct(FormFieldService $formFieldService)
    {
        $this->formFieldService = $formFieldService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            if ($request->datatable == '1') {
                return DataTables::of(FormFieldResource::collection(FormField::where('form_id', $request->form_id)->get()??[]))->make(true);
            }
            return $this->successResponse('Form Retrieved successfully', FormFieldResource::collection(FormField::where('form_id', $request->form_id)->get()));
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
    public function store(FormFieldRequest $request)
    {
        try {
            $formFieldStore = $this->formFieldService->storeFormField($request);
            if (gettype($formFieldStore) === 'object') {
                return $this->successResponse('Form field stored Successfully', new FormFieldResource($formFieldStore));
            } else {
                return $this->exceptionResponse($formFieldStore ?? 'Something went wrong! please try again later');
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
    public function update(FormFieldRequest $request, $id)
    {
        try {
            $formFieldStore = $this->formFieldService->updateFormField($request, $id);
            if (gettype($formFieldStore) === 'object') {
                return $this->successResponse('Form field updated Successfully', new FormFieldResource($formFieldStore));
            } else {
                return $this->exceptionResponse($formFieldStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function sectionFieldMapper(MapperRequest $request, $id)
    {
        try {
            $mapSectionField = $this->formFieldService->mapSectionField($request, $id);
            if (gettype($mapSectionField) === 'object') {
                return $this->successResponse('Mapping section with fields has done Successfully', new FormFieldResource($mapSectionField));
            } else {
                return $this->exceptionResponse($mapSectionField ?? 'Something went wrong! please try again later');
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
    public function destroy($id)
    {
        try {
            $formFieldStore = $this->formFieldService->deleteFormField($id);
            if (gettype($formFieldStore) === 'boolean') {
                return $this->successResponse('FormField deleted Successfully', $formFieldStore);
            } else {
                return $this->exceptionResponse($formFieldStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }
}
