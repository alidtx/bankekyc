<?php

Route::group(['prefix' => 'api/v1', 'middleware' => ['api', 'cors'], 'namespace' => 'Api\v1'], function () {
    Route::get('form/types', 'FormBuilderApiController@getFormTypes');
    Route::resource('form-builder', 'FormBuilderApiController');
    Route::get('form-details/{form}', 'FormBuilderApiController@getFormDetails');
    Route::post('form/submit', 'FormBuilderApiController@submitForm');
    Route::delete('form/delete/{form}', 'FormBuilderApiController@destroy');
});

Route::group(['prefix' => 'api/v1', 'middleware' => ['cors'], 'namespace' => 'Api\V1'], function () {
    Route::get('form/{id}/sections', 'FormController@sections');
    Route::post('form/{form}/details', 'FormController@details');
    Route::resource('form', 'FormController');
    Route::resource('form-section', 'FormSectionController');
    Route::post('form/field/{id}/section-mapper', 'FormFieldController@sectionFieldMapper');
    Route::resource('form-field', 'FormFieldController');
    Route::get('partners', 'FormController@partners');
    Route::get('form-types', 'FormController@formTypes');
    Route::get('form-types-admin', 'FormController@formTypesAdmin');
    Route::get('form-type/{id}/forms', 'FormController@formsByType');
    Route::get('parent-forms', 'FormController@parentForms');
    Route::get('form/{id}/platforms', 'FormSectionController@platformList');
    Route::get('form/{id}/childs', 'FormController@getChildForms');

    // application part. form submit from customers and agents
    //Route::post('application/generateRequestTrackingId', 'ApplicationController@generateRequestTrackingId');
    //Route::post('application/submit', 'ApplicationController@submit');
    //Route::post('application/agent/submit', 'ApplicationController@agentSubmit');
    Route::post('application/{verifier}/submit', 'ApplicationController@verifierSubmit');
    //Route::post('application/submit/confirm', 'ApplicationController@finalSubmit');
    Route::post('application/{verifier}/submit/confirm', 'ApplicationController@verifierFinalSubmit');
    //Route::post('application/media', 'ApplicationController@submitMediaFiles');
    //    Route::post('application/media-nid', 'ApplicationController@submitMediaFilesNID');  // no need

    Route::post('application/nominee-nid-verification', 'ApplicationController@nomineeVerification'); // nominee verification for the time being

    Route::post('application', 'ApplicationController@getApplication');
    Route::post('getAccountType', 'FormSettingsController@getAccountType');
    Route::post('addAccountType', 'FormSettingsController@addAccountType');
    Route::post('editAccountType', 'FormSettingsController@editAccountType');
    Route::get('statusChangeAccountType', 'FormSettingsController@statusChangeAccountType');

    Route::post('getFormType', 'FormSettingsController@getFormType');
    Route::get('accountType', 'FormSettingsController@accountType');
    Route::post('addFormType', 'FormSettingsController@addFormType');
    Route::post('editFormType', 'FormSettingsController@editFormType');
});

/*
 *
 *  User 
 * 
 */
Route::group(['prefix' => 'api/v1/user', 'middleware' => ['cors', 'userAuthenticate'], 'namespace' => 'Api\V1'], function () {
    Route::get('form-type/{id}/forms', 'FormController@formsByType');
    //Route::get('form-types', 'FormController@formTypes');
    Route::get('form/{id}/platforms', 'FormSectionController@platformList');
    Route::post('application/generateRequestTrackingId', 'ApplicationController@generateRequestTrackingId');
    Route::post('application/media', 'ApplicationController@submitMediaFiles');
    Route::post('application/submit', 'ApplicationController@submit');
    Route::post('form/{form}/details', 'FormController@details');
    Route::post('application/submit/confirm', 'ApplicationController@finalSubmit');
    Route::get('application/preview', 'ApplicationController@viewApplication');
    Route::post('application/addNewSectionForm', 'ApplicationController@addNewSectionForm');
});

/*
 *
 *  agent 
 * 
 */
Route::group(['prefix' => 'api/v1/agent', 'middleware' => ['cors', 'auth:agent'], 'namespace' => 'Api\V1'], function () {
    Route::get('form-type/{id}/forms', 'FormController@formsByType');
    //Route::get('form-types', 'FormController@formTypes');
    Route::post('application/generateRequestTrackingId', 'ApplicationController@generateRequestTrackingId');
    Route::post('application/agent/submit', 'ApplicationController@agentSubmit');
    Route::get('form/{id}/platforms', 'FormSectionController@platformList');
    Route::post('application/media', 'ApplicationController@submitMediaFiles');
    Route::post('form/{form}/details', 'FormController@details');
    Route::post('application/submit/confirm', 'ApplicationController@finalSubmit');
});
