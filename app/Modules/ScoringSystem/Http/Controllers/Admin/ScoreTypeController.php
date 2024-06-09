<?php

namespace App\Modules\ScoringSystem\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Modules\ScoringSystem\Models\ScoreType;
use App\Modules\ScoringSystem\Models\ScoreQuestionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ScoreTypeController extends Controller {

    use ApiResponseTrait;

    public function __construct() {
        
    }

    public function scoreType() {
        try {
            return view('ScoringSystem::admin.scoreType', ['title' => 'Score Type', 'route' => 'scoreType']);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function getScoreTypeList() {
        $results = ScoreType::orderBy('created_at', 'desc')->get()->toArray();
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
            $x = array(
                '<span class="td-f-l">' . $result['score_type_title'] . '</span>',
                '<span class="badge badge-info">Active</span>',
                '<input type="hidden" id="scoreTypeTitle' . $i . '" value="' . $result['score_type_title'] . '"> 
                <input type="hidden" id="scoreTypeId' . $i . '" value="' . $result['score_type_id'] . '">
                <a class="badge badge-info edit_form" href="javaScript:void(0)" onclick="showEdit(' . $i . ')" title="Edit"> <i class="fa fa-edit"></i>Edit</a>'
            );
//            <a href="javaScript:void(0)" onclick="statusChange(' . $status . ',' . $result['id'] . ')" title="' . $statusTitle . '"><i class="' . $statusLinkIcon . '"></i></a>
            $response[] = $x;
            $i++;
        }
        return json_encode(array('data' => $response));
    }

    public function doAddScoreType(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'scoreTypeTitle' => 'required'
            ]);
            if ($validation->fails()) {
                return 3;
            }

            $scoreTypeTitle = trim($request->input('scoreTypeTitle'));
            if (ScoreType::where('score_type_title', $scoreTypeTitle)->count() > 0) {
                return 2;
            }

            $scoreType = new ScoreType;
            $scoreType->score_type_uid = 'SCT' . time();
            $scoreType->score_type_title = $request->scoreTypeTitle;
            $scoreType->save();
            return 1;
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    public function doEditScoreType(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                        'scoreTypeTitle' => 'required',
                        'scoreTypeId' => 'required'
            ]);
            if ($validation->fails()) {
                return 3;
            }

            $scoreTypeTitle = trim($request->input('scoreTypeTitle'));
            $scoreTypeId = trim($request->input('scoreTypeId'));
            if (ScoreType::whereNotIn('score_type_id', [$scoreTypeId])->where('score_type_title', $scoreTypeTitle)->count() > 0) {
                return 2;
            }

            $scoreType = ScoreType::where('score_type_id', $scoreTypeId)->first();
            if (!$scoreType) {
                return 3;
            }
            
            $scoreType->score_type_title = $request->scoreTypeTitle;
            $scoreType->save();
            return 1;
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

}
