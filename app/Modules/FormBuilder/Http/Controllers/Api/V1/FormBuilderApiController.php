<?php

namespace App\Modules\FormBuilder\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormType;
use App\Modules\FormBuilder\Models\FormSection;
use App\Modules\FormBuilder\Models\FormField;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class FormBuilderApiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return Datatables::of($this->getAllForms(true))->make(true);
            }
            return view('FormBuilder::form-builder', ['title' => 'Form and Section', 'path' => ['Form & Section'], 'route' => 'form-section']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            if ($request->ajax())
                return $this->exceptionResponse('Something went wrong!');
            abort(500);
        }
    }

    /**
     * Display the module welcome screen
     *
     * @return \App\Traits\json
     */

    public function getFormTypes()
    {
        $formTypes = FormType::get();
        return $this->successResponse('Data retrieved successfully done', $formTypes ?? []);
    }

    public function getAllForms($data_only = false)
    {

        $allForms = Form::with('form_section')->get()->map(function ($form) {
            return collect([
                "id" => $form->id,
                "name" => $form->name,
                "type" => $form->type,
                "method" => $form->method,
                "action_endpoint" => $form->action_endpoint,
                "form_id" => $form->form_id,
                "form_class" => $form->form_class,
                "sections" => $form->form_section->map(function ($section) {
                    return collect([
                        "id" => $section->id,
                        "form_id" => $section->form_id,
                        "title" => $section->name,
                        "section_id" => $section->section_id,
                        "class" => $section->section_class,
                        "sequence" => $section->sequence,
                        'form_fields' => $section->form_fields->map(function ($form_input) {
                            return collect([
                                "id" => $form_input->id,
                                "element_type" => $form_input->field_type,
                                "data_type" => $form_input->data_type,
                                "label" => $form_input->label,
                                "placeholder" => $form_input->placeholders,
                                "name" => $form_input->field_name,
                                "min" => $form_input->min_length,
                                "max" => $form_input->max_length,
                                "value" => $form_input->field_value,
                                "options" => json_decode($form_input->option_params) ?? [json_encode(['key' => '', 'value' => ''])],
                                "additional_attributes" => json_decode($form_input->additional_attributes) ?? [json_encode(['key' => '', 'value' => ''])],
                                "pattern" => $form_input->pattern,
                                "custom_validation" => $form_input->custom_validation,
                                "is_required" => $form_input->is_required,
                                "is_readonly" => $form_input->is_readonly,
                                "is_disabled" => $form_input->is_disabled,
                                "sequence" => $form_input->sequence,

                            ]);
                        })
                    ]);
                })
            ]);
        });
        return $data_only ? $allForms : $this->successResponse('Data retrieved successfully done', $allForms ?? collect([]));
    }

    /**
     * Display the module welcome screen
     *
     * @return \App\Traits\json
     */
    public function getFormDetails(Form $form)
    {
        $formDetails = $form::with('form_section', 'form_section.form_fields')->first();
        return $this->successResponse('Data retrieved successfully done', $formDetails ?? null);
    }

    public function getFormValidationRules()
    {
        return [
            'name' => 'required',
            'type' => 'required',
            'method' => 'required',
            'sections' => 'required|array',
            'sections.*.title' => 'required',
            'sections.*.sequence' => 'required|integer',
            'sections.*.form_fields' => 'required|array',
            'sections.*.form_fields.*.name' => 'required',
            'sections.*.form_fields.*.element_type' => 'required',
            'sections.*.form_fields.*.sequence' => 'required',
            'sections.*.form_fields.*.options' => 'sometimes|array',
            'sections.*.form_fields.*.additional_attributes' => 'sometimes|array'
        ];
    }

    public function submitForm(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->getFormValidationRules());
            if ($validation->fails())
                return $this->invalidResponse($validation->errors()->first());

            DB::begintransaction();
            // insert into form table
            $form = new Form;
            $form->name = $request->name;
            $form->type = $request->type;
            $form->method = $request->input('method');
            $form->action_endpoint = $request->action_endpoint ?? '';
            $form->form_id = $request->form_id ?? '';
            $form->form_class = $request->form_class ?? '';
            $form->save();

            // check and insert into form section table
            if (sizeof($request->sections) > 0) {
                $insertSections = $this->insertSectionAndFields($form->id, $request->sections);
                if ($insertSections) {
                    DB::commit();
                    Log::info('form-data inserted' . json_encode($request->all()));
                    return $this->successResponse('Form submission successful');
                }
            }

            DB::rollback();
            Log::info('form-data insert failed' . json_encode($request->all()));
            return $this->invalidResponse("Something unusual happens. Please check all data properly");

        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            DB::rollback();
            return $this->invalidResponse("Something went wrong. try again later");
        }
    }

    public function insertSectionAndFields($form_id, $sections)
    {
        foreach ($sections as $key => $section) {
            $formSection = new FormSection;
            $formSection->form_id = $form_id;
            $formSection->name = $section['title'];
            $formSection->section_id = $section['section_id'] ?? '';
            $formSection->section_class = $section['class'] ?? '';
            $formSection->sequence = $section['sequence'];
            $formSection->save();

            // check and insert into form fields table
            if (sizeof($section['form_fields']) > 0) {
                foreach ($section['form_fields'] as $key => $field) {
                    $formField = new FormField;
                    $formField->form_id = $form_id;
                    $formField->section_id = $formSection->id;
                    $formField->field_type = $field['element_type'];
                    $formField->data_type = $field['data_type'] ?? '';
                    $formField->label = $field['label'];
                    $formField->placeholders = $field['placeholder'] ?? '';
                    $formField->field_name = $field['name'];
                    $formField->field_value = $field['value'] ?? '';
                    $formField->min_length = $field['min'] ?? '';
                    $formField->max_length = $field['max'] ?? '';
                    $formField->pattern = $field['pattern'] ?? '';
                    $formField->custom_validation = $field['custom_validation'] ?? '';
                    $formField->is_required = $field['is_required'] ?? true;
                    $formField->is_readonly = $field['is_readonly'] ?? false;
                    $formField->is_disabled = $field['is_disable'] ?? false;
                    $formField->sequence = $field['sequence'];
                    $formField->option_params = sizeof($field['options']) > 0 ? json_encode($field['options']) : null ?? null;
                    $formField->additional_attributes = sizeof($field['additional_attributes']) > 0 ? json_encode($field['additional_attributes']) : null ?? null;

                    $formField->save();
                }
                return true;
            }
        }
        return false;
    }

    public function destroy(Form $form)
    {
        try {
            DB::begintransaction();
            $form->form_section()->delete();
            $form->form_fields()->delete();
            if ($form->delete()) {
                DB::commit();
            } else {
                DB::rollback();
            }
            return $this->successResponse('Form has deleted successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return $this->invalidResponse("Something went wrong. try again later");
        }
    }
}
