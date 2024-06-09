<?php

namespace App\Modules\ScoringSystem\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Modules\ScoringSystem\Models\ScoreType;
use App\Modules\ScoringSystem\Models\ScoreQuestionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ScoreQuestionnariesGroupController extends Controller {

    use ApiResponseTrait;

    public function __construct() {
        
    }

    public function scoreQuestionnariesGroup() {
//        $x = ScoreQuestionGroup::with('scoreType')->orderBy('created_at', 'desc')->get()->toArray();
//        echo "<pre>";
//        print_r($x);
//        exit();

        try {
            $scoreTypes = ScoreType::get()->toArray();
            return view('ScoringSystem::admin.scoreQuestionnariesGroup', ['title' => 'Score Questionnaries Group', 'route' => 'scoreQuestionnariesGroup', 'scoreTypes' => $scoreTypes]);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function getQuestionnaireGroupList() {
        $results = ScoreQuestionGroup::with('scoreType')->orderBy('created_at', 'desc')->get()->toArray();
        $response = array();
        $i = 1;
        foreach ($results as $result) {
            $statusName = "";
//            $status = "";
//            $statusTitle = "";
//            $statusLinkIcon = "";
//            if ($result['is_active'] == 1) {
//                $status = 1;
//                $statusName = '<span class="label label-success">Active</span>';
//                $statusTitle = "Do Inactive";
//                $statusLinkIcon = "fa fa-thumbs-o-up";
//            } else if ($result['is_active'] == 0) {
//                $status = 0;
//                $statusName = '<span class="label label-danger">Inactive</span>';
//                $statusTitle = "Do active";
//                $statusLinkIcon = "fa fa-thumbs-o-down";
//            }
//            <button class='badge badge-info edit_form'> <i class="fa fa-edit"></i>Edit</button>
            $isDisplay = ($result['is_display_title'] ) ? 'Yes ' : 'No';
            $x = array(
                '<span>' . $result['score_type']['score_type_title'] . '</span>',
                '<span>' . $result['group_title'] . '</span>',
                '<span>' . $result['group_sequence'] . '</span>',
                '<span>' . $isDisplay . '</span>',
                '<span class="badge badge-info">Active</span>',
                '<input type="hidden" id="scoreTypeTitle' . $i . '" value="' . $result['score_type']['score_type_title'] . '"> 
                <input type="hidden" id="scoreTypeUId' . $i . '" value="' . $result['score_type_uid'] . '">
                <input type="hidden" id="groupTitle' . $i . '" value="' . $result['group_title'] . '">
                <input type="hidden" id="groupSequence' . $i . '" value="' . $result['group_sequence'] . '">
                <input type="hidden" id="isDisplayTitle' . $i . '" value="' . $result['is_display_title'] . '">
                <input type="hidden" id="groupId' . $i . '" value="' . $result['group_id'] . '">
                <a class="badge badge-info edit_form" href="javaScript:void(0)" onclick="showEdit(' . $i . ')" title="Edit"> <i class="fa fa-edit"></i>Edit</a>'
            );
//            <a href="javaScript:void(0)" onclick="statusChange(' . $status . ',' . $result['id'] . ')" title="' . $statusTitle . '"><i class="' . $statusLinkIcon . '"></i></a>
            $response[] = $x;
            $i++;
        }
        return json_encode(array('data' => $response));
    }

    public function doAddQuestionnaireGroup(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'scoreType' => 'required',
                        'groupTitle' => 'required'
            ]);
            if ($validation->fails()) {
                return 3;
            }

            $groupTitle = trim($request->input('groupTitle'));
            if (ScoreQuestionGroup::where('group_title', $groupTitle)->count() > 0) {
                return 2;
            }

            $scoreQuestionGroup = new ScoreQuestionGroup;
            $scoreQuestionGroup->score_type_uid = $request->input('scoreType');
            $scoreQuestionGroup->group_title = $groupTitle;
            $scoreQuestionGroup->group_sequence = (int) $request->input('groupSequence');
            $scoreQuestionGroup->is_display_title = ($request->input('isDisplayTitle')) ? 1 : 0;
            $scoreQuestionGroup->save();
            return 1;
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function doEditQuestionnaireGroup(Request $request) {
        try {

           
            $validation = Validator::make($request->all(), [
                        'scoreType' => 'required',
                        'groupTitle' => 'required',
                        'groupId' => 'required'
            ]);
            if ($validation->fails()) {
                return 3;
            }

            $scoreType = trim($request->input('scoreType'));
            $groupTitle = trim($request->input('groupTitle'));
            $groupId = trim($request->input('groupId'));
            if (ScoreQuestionGroup::whereNotIn('group_id', [$groupId])->where('group_title', $groupTitle)->count() > 0) {
                return 2;
            }

            $scoreQuestionGroup = ScoreQuestionGroup::where('group_id', $groupId)->first();
            if (!$scoreQuestionGroup) {
                return 3;
            }

            
            ScoreQuestionGroup::where('group_id', $groupId)->update(array('score_type_uid' => $scoreType,
                'group_title' => $groupTitle,
                'group_sequence' => (int) $request->input('groupSequence'),
                'is_display_title' => ($request->input('isDisplayTitle')) ? 1 : 0
                ));
            
            return 1;
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!'.$ex);
        }
    }

}
