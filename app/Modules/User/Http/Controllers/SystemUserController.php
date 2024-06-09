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

class SystemUserController extends Controller {

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (!auth()->user()->can('System User Management'))
            abort(403);
        // $users = User::where('type','!=','Super Admin')->get();
        $users = User::get();
        $roles = Role::pluck('name', 'name');
        return view("User::system.index", compact('users', 'roles'));
    }

    public function store(Request $request) {
        if (!auth()->user()->can('System User Management'))
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
            $user->type = $request->role;
            $user->branch = $request->branch;
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
        if (!auth()->user()->can('System User Management'))
            abort(403);

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'email' => 'required',
            'mobile_no' => 'required',
            'role' => 'required|exists:roles,name'
        ]);

        try {
            DB::begintransaction();
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->mobile_no = $request->mobile_no;
            $user->type = $request->role;
            $user->branch = $request->branch;
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
        if (!auth()->user()->can('System User Management'))
            abort(403);

        try {
            User::where('id', $id)->delete();

            return redirect()->back()->with("success", "User Successfully Deleted");
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return redirect()->back()->withErrors('Something went wrong. Please try again')->withInput();
        }
    }

    public function changePassword(Request $request) {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = auth()->user();
        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->with('success', "Password successfully changed");
        } else {
            return redirect()->back()->withErrors("Password did not match");
        }
    }

}
