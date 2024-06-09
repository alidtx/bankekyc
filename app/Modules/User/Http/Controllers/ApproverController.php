<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class ApproverController extends Controller {

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (!auth()->user()->can('Approver Management'))
            abort(403);
        $users = User::where('type','approver')->get();
        $roles = Role::pluck('name', 'name');
        return view("User::approver.index", compact('users', 'roles'));
    }

    public function store(Request $request) {
        if (!auth()->user()->can('Approver Management'))
            abort(403);

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'mobile_no' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|exists:roles,name'
        ]);

        try {
            DB::begintransaction();

            $user = new User();
            $user->name = $request->name;
            $user->mobile_no = $request->mobile_no;
            $user->email = $request->email;
            $user->type = 'approver';
            $user->password = Hash::make($request->password);
            $user->created_at = Carbon::now();
            $user->save();

            $user->assignRole($request->role);

            DB::commit();

            return redirect()->back()->with("success", "User Create Successfully");
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return redirect()->back()->withErrors('Something went wrong. Please try again')->withInput();
        }
    }

    public function update($id, Request $request) {
        if (!auth()->user()->can('Approver Management'))
            abort(403);

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'mobile_no' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|exists:roles,name'
        ]);

        try {
            DB::begintransaction();
            $user = User::where('type', 'approver')->findOrFail($id);
            $user->name = $request->name;
            $user->mobile_no = $request->mobile_no;
            $user->email = $request->email;
            $user->save();

            $user->syncRoles([$request->role]);
            DB::commit();

            return redirect()->back()->with("success", "User Successfully Updated");
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return redirect()->back()->withErrors('Something went wrong. Please try again')->withInput();
        }
    }

    public function destroy($id) {
        if (!auth()->user()->can('Approver Management'))
            abort(403);

        try {
            User::where('id', $id)->where('type', 'approver')->delete();

            return redirect()->back()->with("success", "User Successfully Deleted");
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return redirect()->back()->withErrors('Something went wrong. Please try again')->withInput();
        }
    }

}
