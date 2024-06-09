<?php

Route::group(['namespace' => 'Api\V1', 'prefix' => 'api/v1'], function () {
    Route::get('score-type/{score_type_uid?}', 'ScoreSystemMVPController@getScoreType');
    Route::get('scoring-questionnaire', 'ScoreSystemMVPController@getScoringQuestionnaire');
    Route::post('score-generator', 'ScoreSystemMVPController@scoreGenerator');

    Route::post('score-type', 'ScoreTypeController@store');
    Route::post('score-group', 'ScoreQuestionnaireGroup@store');
});
