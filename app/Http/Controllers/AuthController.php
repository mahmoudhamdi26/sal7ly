<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    use SendsPasswordResetEmails;


    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login', 'refresh']);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = Auth::user();
        return response()->json(compact('token', 'user'));
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::getToken();
            $new_token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $exception) {
            return response()->json(["message" => "you are not authorized"])->setStatusCode(401);
        } catch (TokenBlacklistedException $exception) {
            return response()->json(["message" => "you are not authorized"])->setStatusCode(401);
        }
        return response()->json(["token" => $new_token]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 200);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function confirm_mobile(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $this->validate($request,
            [
                'pin' => 'required|regex:/^[0-9]{4}$/',
            ]);


        if ($user->confirm_code == $request->pin) {
            $user->is_mobile_confirmed = true;
            $user->save();
            return response()->json(['message' => 'mobile confirmed successfully']);
        }

        return response()->json(['pin' => 'code does not match the sent code'], 402);

    }

    public function update(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $this->validate($request,
            [
                'mobile' => 'regex:/(01)[0-9]{9}/',
                'name' => 'string',
                'address' => 'string',
                'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            ]);

        if ($request->has('mobile') && $request->mobile != $user->mobile) {
            $this->sendSms($user);
        }

        $inputs = $request->only(['mobile', 'name', 'address', 'email']);
        $user->update($inputs);

        return response()->json(['user' => $user]);
    }

    private function sendSms($user)
    {
        $pin = mt_rand(1000, 9999);
        $user->confirm_code = $pin;
        $user->save();
        #TODO send the pin to user for confirmation
    }

    public function forget(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);

        $this->sendResetLinkEmail($request);

        return response()->json(
            ['success' => 1]
        );
    }


}
