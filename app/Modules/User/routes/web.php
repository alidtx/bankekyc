<?php

Route::group(['middleware' => 'auth'], function () {
    Route::resource('system-users', 'SystemUserController');
    // Route::put('system-users/edit/{user_id}','SystemUserController@update')->name('edit-user');
    Route::post('change-password','SystemUserController@changePassword')->name('change-password');

    Route::resource('agents', 'AgentController');
});
