<?php

namespace App\Modules\FormBuilder\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Modules\FormBuilder\Models\FormFieldQuestionnaires;
use App\Modules\FormBuilder\Models\FormFieldQuestionnairesOption;
use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormSection;
use App\Modules\FormBuilder\Models\FormType;
use App\Modules\FormBuilder\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\Modules\ScoringSystem\Models\ScoreQuestionnaireOption;
use App\Modules\ScoringSystem\Models\ScoreQuestionnaire;
use Illuminate\Support\Facades\Validator;

class FormBuilderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function form(Request $request) {
        try {
            $formTypes = FormType::all();
            $forms = Form::all();
            $partners = Partner::all();
            return view('FormBuilder::admin.form', ['forms' => $forms, 'formTypes' => $formTypes, 'partners' => $partners, 'title' => 'Form and Section', 'path' => ['Form'], 'route' => 'form']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            if ($request->ajax())
                return $this->exceptionResponse('Something went wrong!');
            abort(500);
        }
    }

    public function formSection(Request $request, $id) {
        try {
            $form = Form::find($id);
            if (!!$form) {
                $platforms = explode(',', $form->allowed_platform_type);
            } else {
                abort(404);
            }
            $forms = Form::all();
            $selectedForm = Form::where('id', $id)->first();
            return view('FormBuilder::admin.form-section', ['selectedForm' => $selectedForm, 'forms' => $forms, 'id' => $id, 'platforms' => $platforms, 'title' => 'Form and Section', 'path' => ['Back Form'], 'route' => 'form']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            if ($request->ajax())
                return $this->exceptionResponse('Something went wrong!');
            abort(500);
        }
    }

    public function formField(Request $request, $id) {
        try {
            $selectedForm = Form::find($id);
            return view('FormBuilder::admin.form-field', ['id' => $id, 'selectedForm' => $selectedForm, 'title' => 'Form and Section', 'path' => ['Back Form-Section'], 'route' => 'form-section/' . $selectedForm->id]);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            if ($request->ajax())
                return $this->exceptionResponse('Something went wrong!');
            abort(500);
        }
    }

    public function scoreMapping(Request $request, $id) {
        try {
            $formFields = FormField::where('form_id', $id)->where('is_score_mapping', 1)->get()->toArray();
            $questions = ScoreQuestionnaire::where('is_active', 1)->get()->toArray();
            $questionOptions = ScoreQuestionnaireOption::get()->toArray();
            $formFieldQuestionnaires = FormFieldQuestionnaires::with('formFieldQuestionOption')->where('form_id', $id)->get()->toArray();

            $formFieldQuestionnairesLists = FormFieldQuestionnaires::with(array('formFieldQuestionOption', 'formField', 'question'))->where('form_id', $id)->get()->toArray();

//            $formFieldQuestionnairesOption = FormFieldQuestionnairesOption::with('formFieldQuestion')
//                    ->get()
//                    ->toArray();
//            echo "<pre>";
//            print_r($formFieldQuestionnairesLists);
//            //print_r($questionOptions);
//            exit();

            return view('FormBuilder::admin.score-mapping', ['id' => $id, 'formFieldQuestionnairesLists' => $formFieldQuestionnairesLists, 'formFields' => $formFields, 'formFieldsDetails' => json_encode(array('formFieldDetails' => $formFields)), 'questions' => $questions, 'questionOptions' => json_encode(array('questionOptions' => $questionOptions)), 'formFieldQuestionnaires' => json_encode(array('formFieldQuestionnaires' => $formFieldQuestionnaires)), 'title' => 'Score Mapping', 'path' => ['Back Score-Mapping'], 'route' => 'score-mapping/' . $id]);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            if ($request->ajax())
                return $this->exceptionResponse('Something went wrong!');
            abort(500);
        }
    }

    public function doScoreMapping(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'formField' => 'required',
                        'question' => 'required'
            ]);

            if ($validation->fails()) {
                return redirect()->back()->with('error', $validation->fails());
            }

            $formFieldQuestionnairesUid = $request->input('formFieldQuestionnairesUid');

            if ($formFieldQuestionnairesUid) {
                FormFieldQuestionnaires::where('form_field_questionnaires_uid', $formFieldQuestionnairesUid)->delete();
                FormFieldQuestionnairesOption::where('form_field_questionnaires_uid', $formFieldQuestionnairesUid)->delete();
            } else {
                $formFieldQuestionnairesUid = 'FQUES' . time();
            }

            $formFieldQuesnnariesInsertArr = array('form_field_questionnaires_uid' => $formFieldQuestionnairesUid,
                'form_id' => $request->input('formId'), 'form_field_id' => $request->input('formField'), 'questionnaire_uid' => $request->input('question'));

            $optionTableRowSerial = $request->input('optionTableRowSerial');

            $formFieldQuestionnairesOptionArr = array();
            $formFieldQuestionnairesOptionInsertArr = array();
            for ($i = 1; $i < $optionTableRowSerial; $i++) {
                if ($request->input('questionOptionDropDown' . $i)) {
                    $formFieldQuestionnairesOptionArr['form_field_questionnaires_uid'] = $formFieldQuestionnairesUid;
                    $formFieldQuestionnairesOptionArr['form_option_key'] = $request->input('formFieldOptionKey' . $i);
                    $formFieldQuestionnairesOptionArr['questionnaire_option_id'] = $request->input('questionOptionDropDown' . $i);
                    $formFieldQuestionnairesOptionInsertArr[] = $formFieldQuestionnairesOptionArr;
                }
            }

            FormFieldQuestionnaires::insert($formFieldQuesnnariesInsertArr);
            if ($formFieldQuestionnairesOptionInsertArr) {
                FormFieldQuestionnairesOption::insert($formFieldQuestionnairesOptionInsertArr);
            }
            return redirect()->back()->with('success', 'Mapped successfully saved');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            if ($request->ajax())
                return $this->exceptionResponse('Something went wrong!');
            abort(500);
        }
    }

}
