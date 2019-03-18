<?php

namespace App\Http\Controllers;

use App\Libraries\SharedFunctions;
use App\Mail\GeneralTextMail;
use App\models\Country;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{

    public function getRegister(){
        $countries = Country::all();
        return View::make('login.register', compact('countries'));
    }

    public function postRegister(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'lname' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);
        if($validator->fails()){
            return Redirect::to(action('LoginController@getRegister'))->withErrors($validator)->withInput();
        }

        $activation_code = uniqid('activation_').'-'.str_random(60);
        $mobile_activation_code = rand(1000, 99999);

        try{
            $inputs = $request->all();
            $realPass = $inputs['password'];
            $inputs['password'] = bcrypt($inputs['password']);
            $inputs['activation_code'] = $activation_code;
            $inputs['isAdmin'] = 0;
            $inputs['isActive'] = 0;

            $user = User::create($inputs);

            //$this->notify($user);

            if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {
                return Redirect::to(action('HomeController@getIndex'));
            }else{
                Session::flash('message', trans('messages.invalid_credentials'));
                Session::flash('alert-class', 'error');
                return Redirect::to(action('LoginController@getRegister'))->withInput();
            }

        }catch (Exception $ex){
            Session::flash('message', trans('messages.internal_error'));
            Session::flash('alert-class', 'error');
            return Redirect::to(action('LoginController@getRegister'))->withInput();
        }


    }


    public function getLogin(){
        return View::make('login.login');
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email|exists:users,email',
                'password' => 'required',
            ]);

        if($validator->fails()){
            return Redirect::to(action('LoginController@getLogin'))
                ->withErrors($validator)->withInput(Input::all());
        }



        try {
            $email = strtolower(Input::get('email'));
            $password = Input::get('password');
            // attempt to verify the credentials and create a token for the user
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $logMsg = "$email logged in.";
                $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
                // SharedFunctions::registerAction(Auth::user(), 'LOGIN', $routeParts[0],
                //     $routeParts[1], Auth::user()->id, $logMsg);

                return Redirect::to(action('HomeController@index'));
            }else{
                Session::flash('message', trans('labels.invalid_credentials'));
                Session::flash('alert-class', 'error');
                return Redirect::to(action('LoginController@getLogin'))->withInput(Input::all());
            }
        } catch (Exception $e) {

        }
    }

    public function getLogout(){
        $user = Auth::user();
        $logMsg = "$user->name logged out";
        $routeParts = explode('@', Route::getCurrentRoute()->getActionName());
        // SharedFunctions::registerAction($user, 'LOGOUT',
        //     $routeParts[0], $routeParts[1], $user->id, $logMsg);

        Auth::logout();
        return Redirect::to(action('LoginController@getLogin'));
    }


    public function postResetPassword(Request $request){
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email|unique:users,email',
            ]);
        if($validator->fails()){
            return Redirect::to(action('LoginController@getRegister'))->withErrors($validator)->withInput();
        }

        $user = User::where('email', Input::get('email'))->first();
        $newPass = str_random(8);

        try{
            $user->password = bcrypt($newPass);
            $user->save();


            /// Get email for user who insert the data
            $title = 'Password  Reset';
            $emailMsg = 'Welcome '.$user->name.','
                . '<br/>Your new password is: '.$newPass.'<br/>';
            Mail::to($user->email)
                ->send(new GeneralTextMail($user, $title, $emailMsg));

            Session::flash('message', trans('messages.password_updated'));
            return Redirect::to(action('LoginController@getRegister'))->withInput();

        }catch (Exception $ex){
            Session::flash('message', trans('messages.internal_error'));
            Session::flash('alert-class', 'error');
            return Redirect::to(action('LoginController@getRegister'))->withInput();
        }
    }

    protected function notify(User $user){

//        $emailBody = 'Please follow the next link to activate your email<br/>'.
//            '<a href="'.action('ProfileController@getActivate', $user->activation_code).'">Activate My Email</a>';
//        //$msgBody = 'Your activation code is '.$user->phoneActivationCode;
//        $msgBody = 'Thank you for registering with our consultation services,\nAn activation email has been sent to your mail, please activate it in order to access your account.';
        $emailData= [
            'name'=>$user->name,
            'link'=>action('UserController@getActivate', $user->activation_code)
        ];
        SharedFunctions::sendEmailTo('emails.welcome', $user->email,
            'Register mail', $emailData);
        //SharedFunctions::sendSMS($user->phone, $msgBody);
    }
}
