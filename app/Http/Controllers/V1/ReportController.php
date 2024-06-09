<?php

namespace App\Http\Controllers\V1;

use DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Modules\FormBuilder\Models\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    public function getApplicationByStatus()
    {   
          
        $allFormRequests = FormRequest::where('status', '!=', 'initiated')->get();
        $data['totalSubmission'] = count($allFormRequests);
        $data['totalApproved'] = $allFormRequests->where('status', 'approved')->count();
        $data['totalPending'] = $allFormRequests->where('status', 'submitted')->count() + $allFormRequests->where('status', 'checked')->count();
        $data['totalDeclined'] = $allFormRequests->where('status', 'declined')->count();

        $report['applicationReport'] = $data;
        return $this->successResponse('Application report data has Successfully retrieved', $report);
    }

    public function getBranch(Request $request)
    {
        $branches = DB::table('branches')->when($request->partner_uid, function ($q) use ($request) {
                $q->where('partner_uid', $request->partner_uid);
            })->get();

        return $this->successResponse('Branch data has successfully retrieved', ['branch' => $branches]);
    }

    

}
