<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use JWTAuth;
use JWTException;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Validator;

class TokenController extends Controller
{

    public function __construct(Response $response, Request $request)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Create and Store a new token for current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'username' => 'required|min:4|max:15|string',
            'password' => 'required|min:4|max:15|string',
        ]);
        if ($validator->fails()) return $this->response->errorUnauthorized();

        $credentials = $this->request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->errorInternalError();
        }
        return response()->json(compact('token'));
    }
}
