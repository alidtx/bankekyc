<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Branch;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class AgentController extends Controller {

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (!auth()->user()->can('Agent Management'))
            abort(403);
        $branches = Branch::get()->toArray();
     
        $agents = Agent::with('branchInfo')->get();
        return view("User::agent.index", compact('agents', 'branches'));
    }

    public function store(Request $request) {
        if (!auth()->user()->can('Agent Management'))
            abort(403);

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'mobile_no' => 'required|unique:agents',
            'email' => 'required|unique:agents',
            'password' => 'required|confirmed|min:8',
            'branch' => 'required',
        ]);

        try {
            DB::begintransaction();

            $agent = new Agent();
            $agent->name = $request->name;
            $agent->mobile_no = $request->mobile_no;
            $agent->email = $request->email;
            $agent->branch = $request->branch;
            $agent->address = $request->address;
            $agent->password = Hash::make($request->password);
            $agent->created_at = Carbon::now();
            $agent->save();

            DB::commit();

            return redirect()->back()->with("success", "Agent Create Successfully");
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return redirect()->back()->withErrors('Something went wrong. Please try again')->withInput();
        }
    }

    public function update($id, Request $request) {
        if (!auth()->user()->can('Agent Management'))
            abort(403);

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'email' => 'required',
            'mobile_no' => 'required',
            'branch' => 'required',
        ]);
        // echo $id;

        try {
            DB::begintransaction();
            $agent = Agent::where('agent_id', $id)->first();
            // dd($agent);
            $agent->name = $request->name;
            $agent->mobile_no = $request->mobile_no;
            $agent->email = $request->email;
            $agent->branch = $request->branch;
            $agent->address = $request->address;
            $agent->save();
            if ($agent) {
                Agent::where('agent_id', $id)->update(['name' => $request->name, 'mobile_no' => $request->mobile_no, 'email' => $request->email]);
                DB::commit();
            }

            return redirect()->back()->with("success", "Agent Successfully Updated");
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return redirect()->back()->withErrors('Something went wrong. Please try again')->withInput();
        }
    }

    public function destroy($id) {
        if (!auth()->user()->can('Agent Management'))
            abort(403);

        try {
            Agent::where('agent_id', $id)->delete();

            return redirect()->back()->with("success", "Agent Successfully Deleted");
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return redirect()->back()->withErrors('Something went wrong. Please try again')->withInput();
        }
    }

}
