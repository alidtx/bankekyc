<?php

Route::get('scoring-system', 'ScoringSystemController@welcome');

Route::group(['prefix' => '', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('scoreType', 'ScoreTypeController@scoreType')->name('scoreType');
    Route::get('/getScoreTypeList', 'ScoreTypeController@getScoreTypeList')->name('getScoreTypeList');
    Route::post('/doAddScoreType', 'ScoreTypeController@doAddScoreType')->name('doAddScoreType');
    Route::post('/doEditScoreType', 'ScoreTypeController@doEditScoreType')->name('doEditScoreType');
    
    Route::get('scoreQuestionnariesGroup', 'ScoreQuestionnariesGroupController@scoreQuestionnariesGroup')->name('scoreQuestionnariesGroup');
    Route::get('/getQuestionnaireGroupList', 'ScoreQuestionnariesGroupController@getQuestionnaireGroupList')->name('getQuestionnaireGroupList');
    Route::post('/doAddQuestionnaireGroup', 'ScoreQuestionnariesGroupController@doAddQuestionnaireGroup')->name('doAddQuestionnaireGroup');
    Route::post('/doEditQuestionnaireGroup', 'ScoreQuestionnariesGroupController@doEditQuestionnaireGroup')->name('doEditQuestionnaireGroup');
    
    Route::get('scoreQuestionnaries', 'ScoreQuestionnariesController@scoreQuestionnaries')->name('scoreQuestionnaries');
    Route::get('addScoreQuestionnaries', 'ScoreQuestionnariesController@addScoreQuestionnaries')->name('addScoreQuestionnaries');
    Route::post('/doAddQuestionnaire', 'ScoreQuestionnariesController@doAddQuestionnaire')->name('doAddQuestionnaire');
    Route::get('/getQuestionnaireList', 'ScoreQuestionnariesController@getQuestionnaireList')->name('getQuestionnaireList');
     Route::get('/editScoreQuestionnaries', 'ScoreQuestionnariesController@editScoreQuestionnaries')->name('editScoreQuestionnaries');
     Route::post('/doEditQuestionnaire', 'ScoreQuestionnariesController@doEditQuestionnaire')->name('doEditQuestionnaire');
     
    
    
});
