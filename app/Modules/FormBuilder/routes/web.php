<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('form-builder', 'FormBuilderController@welcome');
    Route::get('form/{id}', 'FormBuilderController@viewForm');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('form-builder', function () {
        return view('FormBuilder::admin.form-builder');
    })->name('form-builder');
});
Route::get('/test', function () {
    return response()->json([
        'message' => 'Successfully data retrieved',
        'status' => 'success',
        ['a' => 2]
    ], 200);
});

Route::post('/test', function () {
    return response()->json([
        'message' => 'Successfully data retrieved',
        'status' => 'success',
        ['a' => 2]
    ], 200);
});
Route::group(['prefix' => '', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('form', 'FormBuilderController@form');
    Route::get('form/{id}/form-section', 'FormBuilderController@formSection');
    Route::get('form/{id}/form-field', 'FormBuilderController@formField');
    Route::get('form/{id}/score-mapping', 'FormBuilderController@scoreMapping');
    Route::post('/doScoreMapping', 'FormBuilderController@doScoreMapping')->name('doScoreMapping');
    Route::get('accountType', 'FormSettingsController@accountType');
    Route::get('formType', 'FormSettingsController@formType');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
