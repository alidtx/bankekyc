<?php

use App\Modules\FormBuilder\Models\Form;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/nidResponse', 'FingerPrintVarificationController@nidResponse')->name('nidResponse');

Route::get('/', function () {
//    return view('welcome');
    return view('customer.form');
});

Route::post('/nidResponse', 'FingerPrintVarificationController@nidResponse')->name('nidResponse');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/home', function () {
        return redirect('dashboard');
    });

    // sacntion screening route
    Route::get('/screening', 'ScreeningController@index');
    Route::post('/screening', 'ScreeningController@store')->name('import-sanction-screening');
    Route::post('/screening/add', 'ScreeningController@addItem')->name('add-sanction-screening');
    // sacntion screening route ends
   
     // sacntion screening route
     Route::get('/finger-print-v', 'FingerPrintVarificationController@index')->name('finger-print-v');
     Route::post('/finger-print-store', 'FingerPrintVarificationController@store')->name('finger-print-v-store');
     Route::post('/finger-print-v/add', 'FingerPrintVarificationController@addItem')->name('add-finger-print-v');
     Route::get('/finger-print-v/status', 'FingerPrintVarificationController@status')->name('add-finger-print-v-status');
       

    //  Route::get('/runExe', 'FingerPrintVarificationController@runExe')->name('runExeFile');


     // sacntion screening route ends

     
    Route::get('/screening/search', 'ScreeningController@search');
    Route::post('/screening/doSearch', 'ScreeningController@doSearch')->name('doSearch');
    
});

Route::get('/agent/login', 'CustomerController@agentLoginForm');
Route::post('/agent/login', 'CustomerController@agentLoginSubmit');

Route::get('/kyc-form', 'CustomerController@index');
Route::get('/customer/vered', 'CustomerController@customerVerfied');
Route::get('/customer/not-verified', 'CustomerController@customerNotVerfied');
Route::get('/kyc-form', 'CustomerController@index');
Route::post('/customer/form/submit', 'CustomerController@submitForm');


Route::get('/application/{platform}/{tracking_id}', 'ApplicationController@viewApplication');
Route::post('/application/checker/submit/{id}', 'ApplicationController@submitCheckerApplication');

Route::post('/application/question/submit/{request_tracking_uid}', 'ApplicationController@generateScore');



Route::group(['prefix' => 'approver','middleware' => 'auth'], function () {
    Route::get('/approved-application', function () {
        return view('approver.approved-application');
    });
    Route::get('/declined-application', function () {
        return view('approver.declined-application');
    });
    Route::get('/pending-application', function () {
        return view('approver.pending-application');
    });
});

Route::group(['prefix' => 'checker','middleware' => 'auth'], function () {
    Route::get('/approved-application', function () {
        return view('checker.approved-application');
    });
    Route::get('/declined-application', function () {
        return view('checker.declined-application');
    });
    Route::get('/pending-application', function () {
        return view('checker.pending-application');
    });
});

Route::get('view-application-demo', function (){
    return view('al-arafah.application-form');
});

Route::get('/testdata', 'ApplicationController@test');