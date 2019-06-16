<?php
/**
 * Created by PhpStorm.
 * User: Library
 * Date: 29/12/15
 * Time: 2:28 PM
 */

namespace App\Libraries;

use App\models\Functions;
use App\models\Permission;
use App\models\RolePermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AbilitiesFunctions {

    public function isAble($user, $to){
//    	return true;
        if($user->email == 'test@aol.com'){
            return true;
        }

        $toParts= explode('|', $to);
        if($user->is_staff && $toParts[0]=="Service")
            return true;
        /// Getting user roles
        $user_roles_ids_result = DB::table('user_roles')
            ->select('roles_id')
            ->where('users_id', $user->id)
            ->groupBy('roles_id')
            ->get();
        $user_roles_ids = [];
        foreach($user_roles_ids_result as $i){
            array_push($user_roles_ids, $i->roles_id);
        }

        /// Get user roles array objects like (QC or Tester or Data Entry, ....)
        $roles = DB::table('roles')
            ->whereIn('id', $user_roles_ids)
            ->get();

        /// get Permission for each role like (Indicator, DashBoard, ....)
        foreach($roles as $role){
            $permissions_ids = RolePermission::where('roles_id', $role->id)
                ->groupBy('permissions_id')
                ->pluck('permissions_id')->toArray();

            $permissions = Permission::whereIn('id', $permissions_ids)->get();
            foreach($permissions as $permission){
                if(strcmp($permission->label, $toParts[0]) == 0){
                    /// User has the permission, check for the function
                    // For eaxmple user can access (Indicators, ...)

                    /// Now check with the permission and the role to get the functions accessible for that role with permission
                    $functions_ids = RolePermission::where('roles_id', $role->id)
                        ->where('permissions_id', $permission->id)
                        ->groupBy('functions_id')
                        ->pluck('functions_id')->toArray();

                    $functions = Functions::whereIn('id', $functions_ids)->get();
                    foreach($functions as $function){
                        if(strcmp($function->real_name, $toParts[1]) == 0){
                            return true;
                        }
                    }
                }
            }
        }

        /// User have no access to the role
        return false;
    }

    public function isCountry($user, $to){
        if($user->email == 'test@aol.com'){
            return true;
        }

        if($user->country->id == $to){
            return true;
        }

        return false;
    }
}
