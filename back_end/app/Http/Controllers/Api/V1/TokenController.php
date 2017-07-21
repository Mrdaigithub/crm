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
        if (Validator::make($request->all(), ['username' => 'required'])->fails()) $this->response->errorUnauthorized(401000);
        if (Validator::make($request->all(), ['password' => 'required'])->fails()) $this->response->errorUnauthorized(401001);
        if (Validator::make($request->all(), ['username' => 'min:4'])->fails()) $this->response->errorUnauthorized(401002);
        if (Validator::make($request->all(), ['password' => 'min:4'])->fails()) $this->response->errorUnauthorized(401003);
        if (Validator::make($request->all(), ['username' => 'max:10'])->fails()) $this->response->errorUnauthorized(401004);
        if (Validator::make($request->all(), ['password' => 'max:15'])->fails()) $this->response->errorUnauthorized(401005);
        if (Validator::make($request->all(), ['username' => 'string'])->fails()) $this->response->errorUnauthorized(401006);
        if (Validator::make($request->all(), ['password' => 'string'])->fails()) $this->response->errorUnauthorized(401007);
        if (Validator::make($request->all(), ['username' => 'exists:users,username'])->fails()) $this->response->errorUnauthorized(401008);
        $credentials = $request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized(401009);
            }
        } catch (JWTException $e) {
            return $this->response->errorInternal(500000);
        }
        return response()->json(compact('token'));
    }
}
