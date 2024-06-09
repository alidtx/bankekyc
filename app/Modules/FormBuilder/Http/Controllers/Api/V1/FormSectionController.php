<?php

namespace App\Modules\FormBuilder\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\FormBuilder\Http\Requests\Api\V1\FormSectionRequest;
use App\Modules\FormBuilder\Http\Resources\Api\V1\FormResource;
use App\Modules\FormBuilder\Http\Resources\Api\V1\FormSectionResource;
use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormSection;
use App\Modules\FormBuilder\Services\Api\V1\FormSectionService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class FormSectionController extends Controller
{
    use ApiResponseTrait;

    public $formSectionService;

    public function __construct(FormSectionService $formSectionService)
    {
        $this->formSectionService = $formSectionService;
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
                return DataTables::of(FormSectionResource::collection(FormSection::where('form_id', $request->form_id)->get() ?? []))->make(true);
            }
            return $this->successResponse('Form Retrieved successfully', FormSectionResource::collection(FormSection::with('form_section')->get()));
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
    public function store(FormSectionRequest $request)
    {
        try {
            DB::beginTransaction();
            $formSectionStore = $this->formSectionService->storeFormSection($request);
            if (gettype($formSectionStore) === 'object') {
                DB::commit();
                return $this->successResponse('Form section stored Successfully', new FormSectionResource($formSectionStore));
            } else {
                DB::rollBack();
                return $this->exceptionResponse($formSectionStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            DB::rollBack();
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
    public function update(FormSectionRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $formSectionStore = $this->formSectionService->updateFormSection($request, $id);
            if (gettype($formSectionStore) === 'object') {
                DB::commit();
                return $this->successResponse('Form section updated Successfully', new FormSectionResource($formSectionStore));
            } else {
                DB::rollBack();
                return $this->exceptionResponse($formSectionStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            DB::rollBack();
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
            $formSectionStore = $this->formSectionService->deleteFormSection($id);
            if (gettype($formSectionStore) === 'boolean') {
                return $this->successResponse('FormSection deleted Successfully', $formSectionStore);
            } else {
                return $this->exceptionResponse($formSectionStore ?? 'Something went wrong! please try again later');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function platformList($id)
    {
        try {
            $form = Form::findOrFail($id);
            $data['platformList'] = explode(',', $form->allowed_platform_type);
            return $this->successResponse('Platform list retrieved Successfully', $data);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }
}
