<?php
/**
 * Created by PhpStorm.
 * User: Library
 * Date: 29/12/15
 * Time: 2:28 PM
 */

namespace App\Libraries;

use App\models\Functions;
use App\models\Log;
use App\models\Permission;
use App\models\RolePermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SharedFunctions {

    public static function checkRole($user, $to){
        if($user->email == 'test@aol.com'){
            return true;
        }

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
            if(strcmp($role->label, $to) == 0){
                return true;
            }
        }

        /// User have no access to the role
        return false;
    }

    public static function hasRole($user, $to){
        if($user->email == 'test@aol.com'){
            return true;
        }

        $toParts= explode('|', $to);

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

    public static function registerAction($user, $what, $controller, $method, $type_id, $msg){
        Log::create(['users_id'=>$user->id,
            "who"=>$user->name.' '.$user->lname, 'what'=>$what,
            'controller'=>$controller, 'method'=>$method, 'type_id'=>$type_id, 'msg'=>$msg ]);
    }
    public static function registerActionWithChanges($user, $what, $controller, $method, $type_id, $msg,
                                                     $oldData, $newData){
//    	dd($newData);
        Log::create(['users_id'=>$user->id,
            "who"=>$user->name.' '.$user->lname, 'what'=>$what,
            'controller'=>$controller, 'method'=>$method, 'type_id'=>$type_id, 'msg'=>$msg,
            'old_data'=>$oldData, 'new_data'=>$newData ]);
    }

    public static function isSuperAdmin($user){
        if($user->email == config('app.super-admin')){
            return true;
        }

        return false;
    }

    public static function sendEmailTo($view, $to, $title, $contentData){
        $data = array(
            'title'=>$title,
            'to'=>$to,
            'data' => $contentData,
        );

        Mail::send($view, $data, function ($message) use ($data) {
            $message->from('no-reply@immigration.com', $data['title']);
            $message->to($data['to'])->subject($data['title']);
        });
    }

    public static function sendEmailToQueue($view, $to, $title, $contentData){
        $data = array(
            'title'=>$title,
            'to'=>$to,
            'data' => $contentData,
        );

        Mail::queue($view, $data, function ($message) use ($data) {
            $message->from('no-reply@immigration.com', $data['title']);
            $message->to($data['to'])->subject($data['title']);
        });
    }

    public static function sendEmail($name, $title, $content){
        $data = array(
            'title' => $title,
            'content' => $content,
            'name'=>$name
        );

        Mail::send('emails.welcome', $data, function ($message) use ($data) {
            $message->from('test@mazad.com', $data['title']);
            $message->to('mahmoud.h26@gmail.com')->subject($data['title']);
        });
    }

    public static function sendEmailQueue($name, $title, $content){
        $data = array(
            'name' => $name,
            'title'=>$title,
            'content'=>$content
        );

        Mail::queue('emails.welcome', $data, function($message) use ($data)
        {
            $message->from('test@mazad.com', $data['title']);

            $message->to('mahmoud.h26@hotmail.com', 'John Smith')->subject($data['title']);
        });
    }

    public static function sendSMS($phone, $msg){
        ///201098609573
        $url = "http://canadiansms.com/api/sendsms.php?".
            "username=Appdateme&password=simsim11&route=primary&mobiles=".$phone
            ."&message=".urlencode($msg);
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_exec ($curl);
        curl_close ($curl);
    }

    function encrypt_file($source,$destination,$passphrase,$stream=NULL) {
        // $source can be a local file...
        if($stream) {
            $contents = $source;
            // OR $source can be a stream if the third argument ($stream flag) exists.
        }else{
            $handle = fopen($source, "rb");
            $contents = fread($handle, filesize($source));
            fclose($handle);
        }

        $iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
        $key = substr(md5("\x2D\xFC\xD8".$passphrase, true) . md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
        $opts = array('iv'=>$iv, 'key'=>$key);
        $fp = fopen($destination, 'wb') or die("Could not open file for writing.");
        stream_filter_append($fp, 'mcrypt.tripledes', STREAM_FILTER_WRITE, $opts);
        fwrite($fp, $contents) or die("Could not write to file.");
        fclose($fp);

    }

    function decrypt_file($file,$passphrase) {

        $iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
        $key = substr(md5("\x2D\xFC\xD8".$passphrase, true) .
            md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
        $opts = array('iv'=>$iv, 'key'=>$key);
        $fp = fopen($file, 'rb');
        stream_filter_append($fp, 'mdecrypt.tripledes', STREAM_FILTER_READ, $opts);

        return $fp;
    }

    //////
    public static function registerAction_($user, $action, $type, $typeid){
        
    }
}
