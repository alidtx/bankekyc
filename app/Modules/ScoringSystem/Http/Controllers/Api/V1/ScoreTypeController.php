<?php

namespace App\Modules\ScoringSystem\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Modules\ScoringSystem\Models\ScoreType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class ScoreTypeController extends Controller
{
   use ApiResponseTrait;
        public function __construct(){

        }
       /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
        */
       public function index()
       {
           try {

           } catch (\Exception $ex) {
               Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
               return $this->exceptionResponse('Something went wrong!');
           }
       }

       /**
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
        */
       public function create()
       {
           try {

           } catch (\Exception $ex) {
               Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
               return $this->exceptionResponse('Something went wrong!');
           }
       }

       /**
        * Store a newly created resource in storage.
        *
        * @param \Illuminate\Http\Request $request
        * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
        */
       public function store(Request $request)
       {
           try {
            $validation = Validator::make($request->all(), [
                'score_type_title' => 'required'
            ]);

            $scoreType = new ScoreType;
            $scoreType->score_type_uid = 'SCT'. time();
            $scoreType->score_type_title = $request->score_type_title;
            $scoreType->save();
            return $this->successResponse('Score type has succssfully saved', $scoreType);
        if ($validation->fails())
            return $this->invalidResponse($validation->errors()->first());

           } catch (\Exception $ex) {
               Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
               return $this->exceptionResponse('Something went wrong!');
           }
       }

       /**
        * Display the specified resource.
        *
        * @param int $id
        * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
        */
       public function show($id)
       {
           try {

           } catch (\Exception $ex) {
               Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
               return $this->exceptionResponse('Something went wrong!');
           }
       }

       /**
        * Show the form for editing the specified resource.
        *
        * @param int $id
        * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
        */
       public function edit($id)
       {
           try {

           } catch (\Exception $ex) {
               Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
               return $this->exceptionResponse('Something went wrong!');
           }
       }

       /**
        * Update the specified resource in storage.
        *
        * @param \Illuminate\Http\Request $request
        * @param int $id
        * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
        */
       public function update(Request $request, $id)
       {
           try {

           } catch (\Exception $ex) {
               Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
               return $this->exceptionResponse('Something went wrong!');
           }
       }

       /**
        * Remove the specified resource from storage.
        *
        * @param int $id
        * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
        */
       public function destroy($id)
       {
           try {

           } catch (\Exception $ex) {
               Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
               return $this->exceptionResponse('Something went wrong!');
           }
       }
   }
