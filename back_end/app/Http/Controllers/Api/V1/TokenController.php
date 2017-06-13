<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TokenController extends Controller
{
    use Helpers;

    /**
     * Create a token for current user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $credentials = ['username' => $request->json('username'), 'password' => $request->json('password')];
        try {
            if (! $token = JWTAuth::attempt($credentials)) return response()->json(['error' => 'invalid_credentials'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
}
