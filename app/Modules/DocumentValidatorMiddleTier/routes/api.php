<?php

Route::group(['namespace' => 'Api\V1', 'prefix' => 'api/v1'], function () {
    Route::post('document-validation-and-details', 'ThirdPartyAPIMiddleTierController@getDocumentValidationAndDetails');
    Route::post('nid-verification', 'ThirdPartyAPIMiddleTierController@checkNidStatus');
});
