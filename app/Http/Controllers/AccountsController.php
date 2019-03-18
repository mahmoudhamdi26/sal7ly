<?php

namespace App\Http\Controllers;

use App\Libraries\SharedFunctions;
use App\models\Country;
use App\models\Role;
use App\models\UserPermission;
use App\models\UserRole;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex(){
        if (Gate::denies('check-ability', 'Users|List')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::all();
        $users = User::paginate(20);
        $usersCount = User::count();

        return View::make('accounts.index', compact('users', 'roles', 'usersCount'));
    }

    public function getFilter(){

        if (Gate::denies('check-ability', 'Users|List')) {
            abort(403, 'Unauthorized action.');
        }

        $usersQ = User::orderBy('name'); //::where('isactive', true);

        if(Input::has('roles_id')){
            $rolesUsersIDs = UserRole::where('roles_id', Input::get('roles_id'))
                ->pluck('users_id')->toArray();
            $usersQ->whereIn('id', $rolesUsersIDs);
        }

        $users = $usersQ->paginate(20);

        return View::make('accounts.ajax_list', compact('users'));
    }

    //////
    public function getCreate(){
        if (Gate::denies('check-ability', 'Users|Create')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::orderBy('label')->get();

        return View::make('accounts.create', compact('roles'));
    }
    public function postCreate(Request $request){
        if (Gate::denies('check-ability', 'Users|Create')) {
            abort(403, 'Unauthorized action.');
        }


        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required',
            ]);


        DB::beginTransaction();
        try{
            $inputs = $request->all();
//            if(!empty(Input::get('birth_date'))){
//                $startDate = Carbon::createFromFormat('d-m-Y', Input::get('birth_date'));
//                $inputs['birth_date'] = $startDate;
//            }else{
//                unset($inputs['birth_date']);
//            }

            $activation_code = uniqid('activation_').'-'.str_random(60);
            $realPass = $inputs['password'];
            $inputs['password'] = bcrypt($inputs['password']);
            $inputs['activation_code'] = $activation_code;
//            $inputs['isAdmin'] = 1;
            $inputs['isactive'] = 1;
            $inputs['email'] = strtolower($inputs['email']);
            /// Insert Field
            $item = User::create($inputs);
            $newData = $item->toJson();

            //// Roles
            if(Input::has('roles')){
                $roles = $inputs['roles'];
                if(!empty($roles) && count($roles)>0){
                    $item->roles()->sync($roles);
                }

                /// Updating roles
                foreach($item->roles as $role){
                    $role->num_of_users = $role->num_of_users +1;
                    $role->save();
                }
            }


            //// Logging
            $logMsg = "Creating Account";
            $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
            SharedFunctions::registerActionWithChanges(Auth::user(), 'ACCOUNT-CREATE',
                $routeParts[0], $routeParts[1], $item->id, $logMsg, null, $newData);

        }catch (Exception $ex){
            DB::rollback();

            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');
            return Redirect::back()->withInput();
        }
        DB::commit();

        Session::flash('message', 'User added!');
        return redirect('accounts');
    }

    public function getEdit($id){
        if (Gate::denies('check-ability', 'Users|Update')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();
        $isAdmin= SharedFunctions::checkRole($sessionUser, 'Admins');

        $model = User::findOrFail($id);
        $roles = Role::orderBy('label')->get();

        /// If edited user is superadmin return
        if(!SharedFunctions::isSuperAdmin($sessionUser)){
//            dd($model->email);
//            dd(SharedFunctions::isSuperAdmin($model));
            if(SharedFunctions::isSuperAdmin($model)){
                Session::flash('alert-class', 'danger');
                Session::flash('message', 'Sorry, Can not edit super-admin user.');
                return Redirect::back();
            }
        }

        $selectedRoles = UserRole::where('users_id', $id)->pluck('roles_id')->toArray();


        return View::make('accounts.edit', compact('model',  'roles',
            'selectedRoles', 'isAdmin'));
    }
    public function postUpdate(Request $request, $id){
        if (Gate::denies('check-ability', 'Users|Update')) {
            abort(403, 'Unauthorized action.');
        }
        $sessionUser = Auth::user();

        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'unique:users,email,'.$id,
//                'birth_date' => 'date_format:d-m-Y',
//                'birth_date' => 'required',
//                'job' => 'required',
            ]);


        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);
            if(!SharedFunctions::isSuperAdmin($sessionUser)){
                if(SharedFunctions::isSuperAdmin($user)){
                    Session::flash('alert-class', 'danger');
                    Session::flash('message', 'Sorry, Can not edit super-admin user.');
                    return Redirect::back();
                }
            }

            $oldData = $user->toJson();

            $inputs = $request->all();
            //$inputs['email'] = $user->email;
            $inputs['password'] = $user->password;
//            if(Input::has('birth_date') && !empty(Input::get('birth_date'))){
//                $bdate = Carbon::createFromFormat('d-m-Y', $inputs['birth_date']);
//                $inputs['birth_date'] = $bdate;
//            }else{
//                unset($inputs['birth_date']);
//            }

//            dd($inputs);
            $inputs['email'] = strtolower($inputs['email']);
            /// Insert Field
            $item = $user->update($inputs);
            $newData = $user->toJson();

            //// Roles
            if(Input::has('roles')){
                $oldRoles = UserRole::where('users_id', $id)->pluck('roles_id')->toArray();
                $roles = (!empty($inputs['roles']))?$inputs['roles']:[];
                foreach($oldRoles as $role){
                    if(!in_array($role, $roles)){
                        $roleObject = Role::findOrFail($role);
                        UserRole::where('roles_id', $role)->where('users_id', $user->id)->delete();
                        $roleObject->num_of_users = $roleObject->num_of_users - 1;
                        $roleObject->save();
                    }
                }

                foreach($roles as $role){
                    if(!in_array($role, $oldRoles)){
                        $roleObject = Role::findOrFail($role);
                        UserRole::create(['roles_id'=>$role, 'users_id'=>$user->id]);
                        $roleObject->num_of_users = $roleObject->num_of_users +1;
                        $roleObject->save();
                    }
                }
            }else{
                UserRole::where('users_id', $user->id)->delete();
            }



            //// Logging
            $logMsg = $sessionUser->name." Updating Account ".$user->name;
            $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
            SharedFunctions::registerActionWithChanges(Auth::user(), 'ACCOUNT-UPDATE',
                $routeParts[0], $routeParts[1], $user->id, $logMsg, $oldData, $newData);


        }catch (Exception $ex){
            DB::rollback();

            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');
            return Redirect::back()->withInput();
        }
        DB::commit();

        Session::flash('message', 'User updated!');
        return Redirect::back();
    }

    public function getProfile(){
        $sessionUser = Auth::user();
        $model = $sessionUser;

        return View::make('accounts.profile', compact('model'));
    }
    public function postUpdateProfile(Request $request){
        $sessionUser = Auth::user();

        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'unique:users,email,'.$sessionUser->id,
                'birth_date' => 'date_format:d-m-Y',
            ]);


        DB::beginTransaction();
        try{
            $user = $sessionUser;
            $oldData = $user->toJson();

            $inputs['name'] = $request->get("name");
            $inputs['email'] = $request->get("email");
            $inputs['phone'] = $request->get("phone");
            $inputs['birth_date'] = $request->get("birth_date");
            if(Input::has('birth_date') && !empty(Input::get('birth_date'))){
                $bdate = Carbon::createFromFormat('d-m-Y', $inputs['birth_date']);
                $inputs['birth_date'] = $bdate;
            }else{
                unset($inputs['birth_date']);
            }

            $inputs['email'] = strtolower($inputs['email']);
            /// Insert Field
            $item = $user->update($inputs);
            $newData = $user->toJson();

            //// Logging
            $logMsg = $sessionUser->name." Updated his/her profile ";
            $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
            SharedFunctions::registerActionWithChanges(Auth::user(), 'ACCOUNT-UPDATE',
                $routeParts[0], $routeParts[1], $user->id, $logMsg, $oldData, $newData);
        }catch (Exception $ex){
            DB::rollback();

            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');
            return Redirect::back()->withInput();
        }
        DB::commit();

        Session::flash('message', 'Data updated!');
        return Redirect::back();
    }
    public function postUpdateProfilePassword(Request $request){
        $user = Auth::user();
        $this->validate($request,
            [
                'oldpass' => 'required',
                'pass' => 'required',
            ]);


        if (!Hash::check(Input::get('oldpass'), $user->password)) {
            Session::flash('alert-class', 'danger');
            Session::flash('message', 'The old password you entered is incorrect..');
            return Redirect::back();
        }

        $user->password = bcrypt(Input::get('pass'));
        $user->save();

        //// Logging
        $logMsg = $user->name.' updating his/her password';
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        SharedFunctions::registerAction(Auth::user(), 'ACCOUNT-UPDATE-PASS',
            $routeParts[0], $routeParts[1], $user->id, $logMsg);

        Session::flash('message', 'Password updated.');
        return Redirect::back();
    }

    public function postUpdatePassword(Request $request, $id){
        if (Gate::denies('check-ability', 'Users|Update')) {
            abort(403, 'Unauthorized action.');
        }
        $user = User::findOrFail($id);


        $this->validate($request,
            [
                'oldpass' => 'required',
                'pass' => 'required',
            ]);


        if (!Hash::check(Input::get('oldpass'), $user->password)) {
            Session::flash('alert-class', 'danger');
            Session::flash('message', 'The old password you entered is incorrect..');
            return Redirect::back();
        }

        $user->password = bcrypt(Input::get('pass'));
        $user->save();

        //// Logging
        $logMsg = 'Updating Password For '.$user->name;
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        SharedFunctions::registerAction(Auth::user(), 'ACCOUNT-UPDATE-PASS',
            $routeParts[0], $routeParts[1], $user->id, $logMsg);

        Session::flash('message', 'Password updated.');
        return Redirect::back();
    }
    public function postUpdatePasswordAdmin(Request $request, $id){
        if (Gate::denies('check-ability', 'Users|Update')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();
        $isAdmin= SharedFunctions::checkRole($sessionUser, 'Admins');
        if(!$isAdmin){
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);


        $this->validate($request,
            [
                'pass' => 'required',
            ]);

        $user->password = bcrypt(Input::get('pass'));
        $user->save();

        //// Logging
        $logMsg = 'Updating Password For '.$user->name;
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        SharedFunctions::registerAction(Auth::user(), 'ACCOUNT-UPDATE-PASS',
            $routeParts[0], $routeParts[1], $user->id, $logMsg);

        Session::flash('message', 'Password updated.');
        return Redirect::back();
    }

    public function getDeactivate($id){
        if (Gate::denies('check-ability', 'Users|Update')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $user->isactive=false;
        $user->save();

        //// Logging
        $logMsg = 'Deactivate Account '.$user->name;
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        SharedFunctions::registerAction(Auth::user(), 'ACCOUNT-DEACTIVATE',
            $routeParts[0], $routeParts[1], $user->id, $logMsg);

        Session::flash('message', 'User De-Activated!');
        return Redirect::back();
    }

    public function getActivate($id){
        if (Gate::denies('check-ability', 'Users|Update')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $user->isactive=true;
        $user->save();

        //// Logging
        $logMsg = 'Activate Account '.$user->name;
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        SharedFunctions::registerAction(Auth::user(), 'ACCOUNT-ACTIVATE',
            $routeParts[0], $routeParts[1], $user->id, $logMsg);

        Session::flash('message', 'User Activated!');
        return Redirect::back();
    }

    public function getDelete($id){
        if (Gate::denies('check-ability', 'Users|Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $sessionUser = Auth::user();

        $user = User::findOrFail($id);
        if($user->email == config('app.super-admin')){
            Session::flash('message', "Can't delete super-admin user");
            Session::flash('alert-class', 'info');
            return Redirect::back();
        }

        DB::beginTransaction();
        try{
            /// Updating count
            $roles = $user->roles;
            foreach($user->roles as $role){
                $role->num_of_users = $role->num_of_users -1;
                $role->save();
            }

            UserRole::where('users_id', $user->id)->delete();
//            UserPermission::where('users_id', $user->id)->delete();
	        $user->delete();

        }catch (Exception $ex){
            DB::rollback();

            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');
            return Redirect::back()->withInput();
        }
        DB::commit();

        //// Logging
        $logMsg = $sessionUser->name." Deleting Account ".$user->name;
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        SharedFunctions::registerAction(Auth::user(), 'ACCOUNT-DELETE',
            $routeParts[0], $routeParts[1], $user->id, $logMsg);

        Session::flash('message', 'User Deleted!');
        return Redirect::back();
    }
}
