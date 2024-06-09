<?php

namespace App\Modules\ScoringSystem\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\ScoringSystem\Models\ScoreGeneratedLog;
use App\Modules\ScoringSystem\Models\ScoreQuestionnaire;
use App\Modules\ScoringSystem\Models\ScoreQuestionnaireOption;
use App\Modules\ScoringSystem\Models\ScoreType;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScoreSystemMVPController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function getScoreType(Request $request, $score_type_uid = null)
    {
        try {
            $scoreType = ScoreType::select('score_type_id', 'score_type_uid', 'score_type_title')->when($score_type_uid, function ($q) use ($score_type_uid) {
                $q->where('score_type_uid', $score_type_uid);
            })->get();
            return $this->successResponse('Score type list retrieved successfully', ['score_type' => $scoreType]);
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function getScoringQuestionnaire(Request $request)
    {
        try {
            $scoreType = ScoreType::select('score_type_id', 'score_type_uid', 'score_type_title')
                ->when($request->score_type_uid, function ($q) use ($request) {
                    $q->where('score_type_uid', $request->score_type_uid);
                })->with(['questionnaireGroups' => function ($q) use ($request) {
                    $q->select('group_id', 'score_type_uid', 'group_title', 'group_sequence', 'is_display_title')
                        ->when($request->group_id, function ($q) use ($request) {
                            $q->where('group_id', $request->group_id);
                        });
                }, 'questionnaireGroups.questionnaire' => function ($q) use ($request) {
                    $q->select('questionnaire_id', 'group_id', 'questionnaire_uid', 'score_type_uid', 'questionnaire_title', 'questionnaire_sequence', 'has_multiple_option', 'is_active', 'is_required')
                        ->when($request->questionnaire_uid, function ($q) use ($request) {
                            $q->where('questionnaire_uid', $request->questionnaire_uid);
                        });
                }, 'questionnaireGroups.questionnaire.options' => function ($q) use ($request) {
                    $q->select('option_id', 'questionnaire_uid', 'option_value', 'option_sequence', 'option_score');
                }])->get();
            return $this->successResponse('Data retrieved successfully', ['score_matrix' => $scoreType]);
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
    public function scoreGenerator(Request $request)
    {
        try {
            $scoreSum = 0.0;
            $errors = [];
            if (gettype($request->questionnaires) == 'array') {
                $questionnaires = ScoreQuestionnaire::with('options')->where('score_type_uid', $request->score_type_uid)->get();
                if (count($questionnaires) > 0) {
                    foreach ($questionnaires as $questionnaire) {
                        $currentValue = $this->scoreCalculator($questionnaire, $request);
                        if (gettype($currentValue) == 'double' || gettype($currentValue) == 'integer') {
                            $scoreSum += $currentValue;
                        } else {
                            $errors[] = $currentValue;
                        }
                    }
                    if (count($errors) == 0) {
                        if ($this->storeScoreGeneratedLog($scoreSum, $request)) {
                            return $this->successResponse('Score calculation successfully done', ['score' => $scoreSum]);
                        } else {
                            return $this->invalidResponse('Fail to store the data in generated log');
                        }
                    } else {
                        return $this->invalidResponse($errors);
                    }
                } else {
                    return $this->invalidResponse('Invalid score type uid');
                }
            } else {
                return $this->invalidResponse('Invalid data format');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }

    private function scoreCalculator(ScoreQuestionnaire $questionnaire, Request $request)
    {
        if (!$questionnaire->is_active) return 0;//question is not active
        $gotQuestionnaire = -1;
        foreach ($request->questionnaires as $key => $q) if ($questionnaire->questionnaire_uid == $q['questionnaire_uid']) $gotQuestionnaire = $key;

        if ($questionnaire->is_required && $gotQuestionnaire == -1) return 'The Question ' . $questionnaire->questionnaire_title . ' is required'; // require question is not given

        if ($gotQuestionnaire == -1) return 0; // optional question is not given
        $optionKey = -1;
        try {
            foreach ($questionnaire->options as $option) {
                $index = array_search($option->option_id, $request->questionnaires[$gotQuestionnaire]['options']);
                if ($index !== false) {
                    $optionKey = $index;
                    break;
                }
            }
            if ($questionnaire->is_required && $optionKey == -1) return 'The Question ' . $questionnaire->questionnaire_title . '\'s valid option is required'; // require question's option is not given
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return 'The Question ' . $questionnaire->questionnaire_title . '\'s option format is invalid'; // require question is not given
        }

        $options = $questionnaire->has_multiple_option ? $request->questionnaires[$gotQuestionnaire]['options'] : ($optionKey != -1 ? [$request->questionnaires[$gotQuestionnaire]['options'][$optionKey]] : []);
        $sum = ScoreQuestionnaireOption::whereIn('option_id', $options)->where('questionnaire_uid', $questionnaire->questionnaire_uid)->sum('option_score');
        Log::info('Question_uid => ' . $questionnaire->questionnaire_uid . ' options=>' . json_encode($request->questionnaires[$gotQuestionnaire]['options']) . ' sum => ' . $sum);
        return $sum;
    }

    private function storeScoreGeneratedLog($scoreSum, Request $request, $application_user_id = null, $remarks = '')
    {
        try {
            $generetedLog = ScoreGeneratedLog::create([
                'request_payload' => json_encode(["score_type_uid" => $request->score_type_uid, "questionnaires" => $request->questionnaires]),
                'generated_score' => $scoreSum,
                'user_agent_data' => json_encode($request->user_agent),
                'application_user_id' => $application_user_id,
                'remarks' => $remarks,
            ]);
            return !!$generetedLog;
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());

        }
    }
}
