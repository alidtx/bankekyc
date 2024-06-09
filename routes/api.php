<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FingerPrintVarificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/nidResponse', [FingerPrintVarificationController::class, 'nidResponse']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'V1', 'prefix' => 'v1', 'middleware' => 'cors'], function () {
    Route::get('application/report', 'ReportController@getApplicationByStatus');
    Route::get('branch', 'ReportController@getBranch');
});
Route::group(['namespace' => 'V1\Agent', 'prefix' => 'v1', 'middleware' => 'cors'], function () {
    Route::get('dynamic-application-list', 'AgentActivityController@applicationList');
});

//Route::group(['prefix' => 'api/v1/user', 'middleware' => ['cors', 'userAuthenticate'], 'namespace' => 'V1'], function () {
//    Route::get('branch', 'ReportController@getBranch');
//});

// Route::post('/storeData', 'FingerPrintVarificationController@storeData')->name('storeData');
Route::post('/storeData', [FingerPrintVarificationController::class, 'storeData']);
Route::get('/runExe', [FingerPrintVarificationController::class, 'runExe']);
// Route::get('/nidResponse', [FingerPrintVarificationController::class, 'nidResponse']);
Route::group(['namespace' => 'V1', 'prefix' => 'v1/user', 'middleware' => ['cors', 'userAuthenticate']], function () {
    Route::get('branch', 'ReportController@getBranch');
});
Route::group(['namespace' => 'V1', 'prefix' => 'v1/agent', 'middleware' => ['cors', 'auth:agent']], function () {
    Route::get('branch', 'ReportController@getBranch');
});