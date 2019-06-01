<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use GuzzleHttp\Client;

class FacebookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login']);
    }


    public function login(Request $request)
    {
        $fbToken = $request->token;
        $client = new Client();
        $res = $client->get('https://graph.facebook.com/v2.12/me?fields=name,location,email&access_token=' . $fbToken);
        $code = $res->getStatusCode(); // 200
        $body = json_decode($res->getBody()->getContents());
        $user = User::where('facebook_id', $body->id)
            ->orWhere('email', $body->email)
            ->first();
        if ($user == null) {
            $user = User::create([
                'facebook_id' => $body->id,
                'name' => $body->name,
                'email' => $body->email,
                'address' => $body->location->name,
                'password' => Str::random(8),
            ]);
        }
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('token', 'user'), $code);
    }

}
