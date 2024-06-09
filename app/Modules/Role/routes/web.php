<?php

Route::resource('role', 'RoleController')->middleware('auth');
Route::post('role/create','RoleController@store')->middleware('auth');
Route::put('role/edit/{role_id}','RoleController@update')->middleware('auth');
Route::delete('role/delete/{role_id}','RoleController@destroy')->middleware('auth');
