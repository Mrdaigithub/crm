<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\User\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TokenController extends Controller
{

    use Helpers;


    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $credentials = [
            'username' => $request->json('username'),
            'password' => $request->json('password')
        ];

        try {
            if (!$access_token = JWTAuth::attempt($credentials)) $this->response->errorUnauthorized('username or password is error');
            return $this->response->array(['access_token' => $access_token]);
        } catch (JWTException $e) {
            $this->response->errorInternal('errorInternal');
        }
    }
}
