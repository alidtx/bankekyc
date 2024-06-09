<?php

Route::group(['prefix' => 'api/v1', 'middleware' => ['cors'], 'namespace' => 'Api\V1'], function () {
    Route::post('generateOtp', 'OtpController@generateOtp');
    Route::post('verifyOtp', 'OtpController@verifyOtp');
    Route::get('getSettingDetails', 'AppSettingController@getSettingDetails');
    
    Route::post('agentLogin', 'AgentController@login');
    //Route::get('agentLogout', 'AgentAuthController@logout');
    Route::group(['middleware' => 'auth:agent'], function() {
        Route::get('agentLogout', 'AgentController@logout');
        Route::get('agent/profile', 'AgentController@agentDetails');
        Route::get('agent/application/list', 'AgentController@agentApplicationList');
        Route::post('agent/application/details', 'AgentController@agentApplicationDetails');
        
        
    });
    
});