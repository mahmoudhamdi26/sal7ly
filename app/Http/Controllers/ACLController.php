<?php

namespace App\Http\Controllers;

use App\Libraries\SharedFunctions;
use App\models\Functions;
use App\models\Permission;
use App\models\Role;
use App\models\RolePermission;
use App\models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ACLController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function  getIndex(){
        if (Gate::denies('check-ability', 'ACL|List')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::with('permissions')->get();
        $permissions = Permission::with('functions')->get();

        $rolesPermissions = RolePermission::all();
        $selected = [];
        foreach($rolesPermissions as $item){
            if(array_key_exists($item->roles_id, $selected)){
                array_push($selected[$item->roles_id], $item->functions_id);
            }else{
                $selected[$item->roles_id] = [$item->functions_id];
            }
        }


        return View::make('acl.index', compact('roles', 'permissions', 'selected'));
    }

    public function getCreateRole(){
        if (Gate::denies('check-ability', 'ACL|Create')) {
            abort(403, 'Unauthorized action.');
        }

        $permissions = Permission::all();

        return View::make('acl.create', compact('permissions'));
    }
    public function postCreateRole(Request $request){
        if (Gate::denies('check-ability', 'ACL|Create')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request,
            [
                //'code' => 'required|size:2',
                'label' => 'required',
            ]);

        try{
            $inputs = $request->all();
            $item = Role::create($inputs);


            //// Logging
            $logMsg = 'Creating Role';
            $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
            SharedFunctions::registerAction(Auth::user(), 'ROLE-CREATE',
                $routeParts[0], $routeParts[1], $item->id, $logMsg);

        }catch (Exception $ex){
            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');
            return Redirect::back()->withInput();
        }

        Session::flash('message', 'Item added!');
        return redirect('/acl');
    }

    /// Assign function to role
    public function getToggleAssignFunction(Request $request, $id, $function_id){
        if (Gate::denies('check-ability', 'ACL|Update')) {
            abort(403, 'Unauthorized action.');
        }

        $role = Role::findOrFail($id);
        $function = Functions::findOrFail($function_id);

        /// Check if already assigned
        $item = RolePermission::where('roles_id', $id)
            ->where('functions_id', $function_id)
            ->first();

        if($item != null){
            $item->delete();
            $actionName = "DELETE";
        }else{
            $item = new RolePermission();
            $item->roles_id = $id;
            $item->functions_id = $function_id;
            $item->permissions_id = $function->permissions_id;
            $item->save();

            $actionName = "ASSIGN";
        }

        //// Logging
        $logMsg = $actionName.' Role Function';
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        SharedFunctions::registerAction(Auth::user(), 'ROLE-FUBCTION-'.$actionName,
            $routeParts[0], $routeParts[1], $item->id, $logMsg);

        if($request->ajax()){
            return response()->json(['status'=>1, 'message'=>'success']);
        }else{
            Session::flash('message', 'Success!');
            return redirect('/acl');
        }
    }

    public function getDelete($id){
        if (Gate::denies('check-ability', 'ACL|Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $role = Role::findOrFail($id);
        $numOfUsersIn = UserRole::where('roles_id', $id)->count();
        if($numOfUsersIn > 0){
            Session::flash('message', "Can't delete group with users");
            Session::flash('alert-class', 'danger');
            return Redirect::back();
        }
        DB::beginTransaction();
        try{
            RolePermission::where('roles_id', $role->id)->delete();

            $role->delete();
        }catch (Exception $ex){
            DB::rollback();

            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');
            return Redirect::back()->withInput();
        }
        DB::commit();

        //// Logging
        $logMsg = 'Deleting Role';
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        SharedFunctions::registerAction(Auth::user(), 'ROLE-DELETE',
            $routeParts[0], $routeParts[1], $role->id,$logMsg);

        Session::flash('message', 'Role Deleted!');
        return Redirect::back();
    }

}
