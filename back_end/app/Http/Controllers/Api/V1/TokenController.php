<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth, JWTException;
use Validator;
use Dingo\Api\Routing\Helpers;

class TokenController extends Controller
{
    use Helpers;
    /**
     * Create and Store a new token for current user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|max:15|string',
            'password' => 'required|min:4|max:15|string',
        ]);
        if ($validator->fails()) $this->response->errorUnauthorized();
        $credentials = $request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->errorInternal();
        }
        return response()->json(compact('token'));
    }
}
