<?php

namespace App\Modules\ScoringSystem\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Modules\ScoringSystem\Models\ScoreType;
use App\Modules\ScoringSystem\Models\ScoreQuestionGroup;
use App\Modules\ScoringSystem\Models\ScoreQuestionnaireOption;
use App\Modules\ScoringSystem\Models\ScoreQuestionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ScoreQuestionnariesController extends Controller {

    use ApiResponseTrait;

    public function __construct() {
        
    }

    public function scoreQuestionnaries() {

        try {
            //$scoreTypes = ScoreType::get()->toArray();
            return view('ScoringSystem::admin.scoreQuestionnaries', ['title' => 'Score Questionnaries', 'route' => 'scoreQuestionnaries']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function addScoreQuestionnaries() {

        try {
            $scoreTypes = ScoreType::get()->toArray();
            $scoreQuestionGroup = json_encode(array('scoreQuestionGroupData' => ScoreQuestionGroup::get()->toArray()));
            return view('ScoringSystem::admin.addScoreQuestionnaries', ['title' => 'Score Questionnaries', 'route' => 'scoreQuestionnaries', 'scoreQuestionGroup' => $scoreQuestionGroup, 'scoreTypes' => $scoreTypes]);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function getQuestionnaireList() {
        $results = ScoreQuestionnaire::with(array('questionGroup', 'scoreType', 'options'))->orderBy('created_at', 'desc')->get()->toArray();
        $response = array();
        $i = 1;
        foreach ($results as $result) {
            $statusName = "";
            $status = "";
            $statusTitle = "";
            $statusLinkIcon = "";
            if ($result['is_active'] == 1) {
                $status = 1;
                $statusName = '<span class="badge badge-info">Active</span>';
                $statusTitle = "Do Inactive";
                $statusLinkIcon = "fa fa-thumbs-o-up";
            } else if ($result['is_active'] == 0) {
                $status = 0;
                $statusName = '<span class="badge badge-danger">Inactive</span>';
                $statusTitle = "Do active";
                $statusLinkIcon = "fa fa-thumbs-o-down";
            }
            $isMultipleOption = ($result['has_multiple_option'] ) ? 'Yes ' : 'No';
            $isRequired = ($result['is_required'] ) ? 'Yes ' : 'No';

            $optionStr = "";
            for ($j = 0; $j < count($result['options']); $j++) {
                $optionStr .= '<li><span class="badge badge-success">' . $result['options'][$j]['option_score'] . '</span> ' . (string) $result['options'][$j]['option_value'] . '</li>';
            }

            $x = array(
                '<span>' . $result['question_group']['group_title'] . '</span>',
                '<span>' . $result['score_type']['score_type_title'] . '</span>',
                '<span>' . $result['questionnaire_title'] . '</span>',
                '<span>' . $result['questionnaire_sequence'] . '</span>',
                '<span>' . $isMultipleOption . '</span>',
                '<span>' . $isRequired . '</span>',
                '<ul>' . $optionStr . '</ul>',
                $statusName,
                '<a class="badge badge-info edit_form" href="' . url('editScoreQuestionnaries') . '?questionnarieId=' . $result['questionnaire_id'] . '" title="Edit"> <i class="fa fa-edit"></i>Edit</a>'
            );
            $response[] = $x;
            $i++;
        }
        return json_encode(array('data' => $response));
    }

    public function doAddQuestionnaire(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'scoreType' => 'required',
                        'scoreQuestionGroup' => 'required'
            ]);
            if ($validation->fails()) {
                return redirect('addScoreQuestionnaries')->with('error', $validation->fails());
            }

            $scoreType = trim($request->input('scoreType'));
            $scoreQuestionGroup = trim($request->input('scoreQuestionGroup'));
            $questionCount = (int) $request->input('questionCount');
            //$scoreQuestionnaires = array();
            $scoreQuestionnairesInsertArr = array();
            $scoreQuestionOptionInsertArr = array();
            for ($i = 1; $i <= $questionCount; $i++) {
                $scoreQuestionnaires = array();
                $scoreQuestionnaires['questionnaire_title'] = $request->input('question' . $i);
                if ($scoreQuestionnaires['questionnaire_title']) {
                    $scoreQuestionnaires['group_id'] = $scoreQuestionGroup;
                    $scoreQuestionnaires['questionnaire_uid'] = 'QUES' . time();
                    $scoreQuestionnaires['score_type_uid'] = $scoreType;
                    $scoreQuestionnaires['questionnaire_sequence'] = $request->input('questionSequence' . $i);
                    $scoreQuestionnaires['has_multiple_option'] = ($request->input('isMultipleOption' . $i)) ? 1 : 0;
                    $scoreQuestionnaires['is_active'] = 1;
                    $scoreQuestionnaires['is_required'] = ($request->input('isRequired' . $i)) ? 1 : 0;
                    $scoreQuestionnairesInsertArr[] = $scoreQuestionnaires;

                    $optionCount = $request->input('optionCount' . $i);
                    $optionArr = array();
                    for ($j = 1; $j <= $optionCount; $j++) {
                        $optionValue = $request->input('optionValue' . $i . $j);
                        if ($optionValue) {
                            $optionArr['questionnaire_uid'] = $scoreQuestionnaires['questionnaire_uid'];
                            $optionArr['option_value'] = $optionValue;
                            $optionArr['option_sequence'] = (int) $request->input('optionSequence' . $i . $j);
                            $optionArr['option_score'] = $request->input('optionScore' . $i . $j);
                            $scoreQuestionOptionInsertArr[] = $optionArr;
                        }
                    }
                }
            }
            if ($scoreQuestionnairesInsertArr) {
                ScoreQuestionnaire::insert($scoreQuestionnairesInsertArr);
            }
            if ($scoreQuestionOptionInsertArr) {
                ScoreQuestionnaireOption::insert($scoreQuestionOptionInsertArr);
            }
            return redirect('addScoreQuestionnaries')->with('success', 'Successfully saved');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function editScoreQuestionnaries(Request $request) {
        $validation = Validator::make($request->all(), [
                    'questionnarieId' => 'required'
        ]);
        if ($validation->fails()) {
            return redirect('scoreQuestionnaries');
        }
        $questions = ScoreQuestionnaire::with(array('questionGroup', 'scoreType', 'options'))->where('questionnaire_id', $request->questionnarieId)->first();
//        echo "<pre>";
//        print_r($questions);
//        exit();
        if (!$questions) {
            return redirect('scoreQuestionnaries');
        }
        $questions = $questions->toArray();
        $scoreTypes = ScoreType::get()->toArray();
        $scoreQuestionGroup = json_encode(array('scoreQuestionGroupData' => ScoreQuestionGroup::get()->toArray()));
        return view('ScoringSystem::admin.editScoreQuestionnaries', ['title' => 'Score Questionnaries', 'route' => 'scoreQuestionnaries', 'scoreQuestionGroup' => $scoreQuestionGroup, 'scoreTypes' => $scoreTypes, 'questionDetails' => $questions]);
    }

    public function doEditQuestionnaire(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'scoreType' => 'required',
                        'scoreQuestionGroup' => 'required',
                        'questionnaireId' => 'required'
            ]);
            if ($validation->fails()) {
                return redirect()->back()->with('error', $validation->fails());
            }
//            dd($request->questionnaireId);
//            exit();
            $scoreQuestionnaires = ScoreQuestionnaire::with(array('questionGroup', 'scoreType', 'options'))->where('questionnaire_id', $request->questionnaireId)->first();
//            echo "<pre>";
//            print_r($scoreQuestionnaires);
//            exit();
            if (!$scoreQuestionnaires) {
                return redirect('scoreQuestionnaries');
            }
            $questionnaireUid = $scoreQuestionnaires->questionnaire_uid;

            $scoreType = trim($request->input('scoreType'));
            $scoreQuestionGroup = trim($request->input('scoreQuestionGroup'));
            $deleteOptionArr = array();
            $deleteOptionStr = trim($request->input('deleteOptionStr'));
            if ($deleteOptionStr) {
                $deleteOptionArr = explode(',', $deleteOptionStr);
            }

            $scoreQuestionOptionInsertArr = array();
            $scoreQuestionOptionUpdateArr = array();
            $scoreQuestionnairesUpdateArr['questionnaire_title'] = $request->input('question');
            $scoreQuestionnairesUpdateArr['group_id'] = $scoreQuestionGroup;
            $scoreQuestionnairesUpdateArr['score_type_uid'] = $scoreType;
            $scoreQuestionnairesUpdateArr['questionnaire_sequence'] = $request->input('questionSequence');
            $scoreQuestionnairesUpdateArr['has_multiple_option'] = ($request->input('isMultipleOption')) ? 1 : 0;
            $scoreQuestionnairesUpdateArr['is_required'] = ($request->input('isRequired')) ? 1 : 0;

            $optionCount = $request->input('optionCount');

            for ($j = 1; $j <= $optionCount; $j++) {
                $optionValue = $request->input('optionValue' . $j);
                if ($optionValue) {
                    $optionId = $request->input('optionId' . $j);
                    $optionArr = array();
                    if ($optionId) {
                        //echo $optionId.' a<br>';
                        $optionArr['option_id'] = $optionId;
                        $optionArr['questionnaire_uid'] = $questionnaireUid;
                        $optionArr['option_value'] = $optionValue;
                        $optionArr['option_sequence'] = (int) $request->input('optionSequence' . $j);
                        $optionArr['option_score'] = $request->input('optionScore' . $j);
                        $scoreQuestionOptionUpdateArr[] = $optionArr;
                    } else {
                        //echo $optionId.' b<br>';
                        $optionArr['questionnaire_uid'] = $questionnaireUid;
                        $optionArr['option_value'] = $optionValue;
                        $optionArr['option_sequence'] = (int) $request->input('optionSequence' . $j);
                        $optionArr['option_score'] = $request->input('optionScore' . $j);
                        $scoreQuestionOptionInsertArr[] = $optionArr;
                    }
                }
            }

            //exit();

            ScoreQuestionnaire::where('questionnaire_id', $request->questionnaireId)->update($scoreQuestionnairesUpdateArr);

            if ($scoreQuestionOptionInsertArr) {
                ScoreQuestionnaireOption::insert($scoreQuestionOptionInsertArr);
            }
            if ($scoreQuestionOptionUpdateArr) {
                $this->updateBatch('score_questionnaire_options', 'option_id', $scoreQuestionOptionUpdateArr);
            }
            if ($deleteOptionArr) {
                //ScoreQuestionnaireOption::whereIn('active', $deleteOptionArr)->delete(); 
            }
            return redirect()->back()->with('success', 'Successfully updated');
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!' . $ex);
        }
    }

    public function updateBatch($table, $whereColumn, $arr) {
        //$table = 'psychotherapist_preference';
        //$whereColumn = 'id';
        $i = 0;
        $x = array();
        $whereValueArr = array();
        foreach ($arr as $arrElement) {
            $whereColumnValue = $arrElement[$whereColumn];
            $whereValueArr[] = $whereColumnValue;
            foreach ($arrElement as $element => $elementValue) {
                if ($element == $whereColumn) {
                    continue;
                }
                $elementValue = ($elementValue === NULL) ? 'NULL' : "'" . $elementValue . "'";
                $x[$element][] = " WHEN `" . $whereColumn . "` = '" . $whereColumnValue . "' THEN " . $elementValue;
            }
            $i++;
        }
        //print_r($x);
        foreach ($x as $y => $yValue) {
            $a[] = "`" . $y . "` = CASE " . implode(" ", $yValue) . " ELSE `" . $y . "` END";
        }
        //echo "<br>";
        $query = "UPDATE `" . $table . "` SET " . implode(',', $a) . " WHERE `" . $whereColumn . "` IN (" . implode(',', $whereValueArr) . ")";
        DB::statement($query);
    }

}
