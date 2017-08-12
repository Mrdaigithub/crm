<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use JWTAuth, JWTException;
use Validator;
use Dingo\Api\Routing\Helpers;
use Hash;

class UserController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->roles;
        }
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('users/user/add')) $this->response->errorForbidden(403030);

        $parameters = $request->all();
        if (Validator::make($parameters, ['username' => 'required'])->fails()) $this->response->errorBadRequest(400005);
        if (Validator::make($parameters, ['username' => 'min:4'])->fails()) $this->response->errorBadRequest(400006);
        if (Validator::make($parameters, ['username' => 'max:10'])->fails()) $this->response->errorBadRequest(400007);
        if (Validator::make($parameters, ['username' => 'string'])->fails()) $this->response->errorBadRequest(400008);
        if (Validator::make($parameters, ['username' => 'unique:users'])->fails()) $this->response->errorBadRequest(400009);
        if (Validator::make($parameters, ['password' => 'required'])->fails()) $this->response->errorBadRequest(400010);
        if (Validator::make($parameters, ['password' => 'min:4'])->fails()) $this->response->errorBadRequest(4000011);
        if (Validator::make($parameters, ['password' => 'max:15'])->fails()) $this->response->errorBadRequest(400012);
        if (Validator::make($parameters, ['password' => 'string'])->fails()) $this->response->errorBadRequest(400013);
        if (Validator::make($parameters, ['tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/']])->fails()) $this->response->errorBadRequest(400014);
        if (Validator::make($parameters, ['headimgurl' => ['regex:/^https?:\/\/(([a-zA-Z0-9_-])+(\.)?)*(:\d+)?(\/((\.)?(\?)?=?&?[a-zA-Z0-9_-](\?)?)*)*\.{1}(png|jpg|bmp|gif)$/']])->fails()) $this->response->errorBadRequest(400015);
        if (Validator::make($parameters, ['ip' => 'ip'])->fails()) $this->response->errorBadRequest(400016);
        if (Validator::make($parameters, ['role_id' => 'required'])->fails()) $this->response->errorBadRequest(400017);
        if (Validator::make($parameters, ['role_id' => 'exists:roles,id'])->fails()) $this->response->errorBadRequest(400018);
        if (Validator::make($parameters, ['state' => 'boolean'])->fails()) $this->response->errorBadRequest(400019);

        $user = new User();
        $user->username = $parameters['username'];
        $user->password = bcrypt($parameters['password']);
        if (key_exists('tel', $parameters)) $user->tel = $parameters['tel'];
        if (key_exists('headimgurl', $parameters)) $user->headimgurl = $parameters['headimgurl'];
        if (key_exists('ip', $parameters)) $user->ip = $parameters['ip'];
        if (key_exists('state', $parameters)) $user->state = $parameters['state'];
        if (!$user->save()) $this->response->errorInternal(500001);
        $user->attachRole(Role::find($parameters['role_id']));
        $user->roles;
        return $user;
    }

    /**
     * Display the user by user id.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show_by_uid($id)
    {
        if ($id == 0) return JWTAuth::parseToken()->authenticate();
        if (Validator::make(['id' => $id], ['id' => 'exists:users'])->fails()) $this->response->errorBadRequest(400020);
        return User::find($id);
    }

    /**
     * Display users by role id.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show_by_rid($id)
    {
        if (Validator::make(['id' => $id], ['id' => 'exists:roles'])->fails()) $this->response->errorBadRequest(400003);
        return Role::find($id)->users;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('users/user/edit')) $this->response->errorForbidden(403032);

        $parameters = $request->all();
        $parameters['id'] = $id;
        if (Validator::make($parameters, ['id' => 'exists:users'])->fails()) $this->response->errorBadRequest(400020);
        if (Validator::make($parameters, ['username' => 'min:4'])->fails()) $this->response->errorBadRequest(400006);
        if (Validator::make($parameters, ['username' => 'max:10'])->fails()) $this->response->errorBadRequest(400007);
        if (Validator::make($parameters, ['username' => 'string'])->fails()) $this->response->errorBadRequest(400008);
        if (Validator::make($parameters, ['username' => 'unique:users'])->fails()) $this->response->errorBadRequest(400009);
        if (Validator::make($parameters, ['password' => 'min:4'])->fails()) $this->response->errorBadRequest(4000011);
        if (Validator::make($parameters, ['password' => 'max:15'])->fails()) $this->response->errorBadRequest(400012);
        if (Validator::make($parameters, ['password' => 'string'])->fails()) $this->response->errorBadRequest(400013);
        if (Validator::make($parameters, ['tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/']])->fails()) $this->response->errorBadRequest(400014);
        if (Validator::make($parameters, ['headimgurl' => ['regex:/^https?:\/\/(([a-zA-Z0-9_-])+(\.)?)*(:\d+)?(\/((\.)?(\?)?=?&?[a-zA-Z0-9_-](\?)?)*)*\.{1}(png|jpg|bmp|gif)$/']])->fails()) $this->response->errorBadRequest(400015);
        if (Validator::make($parameters, ['ip' => 'ip'])->fails()) $this->response->errorBadRequest(400016);
        if (Validator::make($parameters, ['role_id' => 'exists:roles,id'])->fails()) $this->response->errorBadRequest(400018);
        if (Validator::make($parameters, ['state' => 'boolean'])->fails()) $this->response->errorBadRequest(400019);

        $user = User::find($id);
        if (key_exists('username', $parameters)) $user->username = $parameters['username'];
        if (key_exists('password', $parameters)) $user->password = bcrypt($parameters['password']);
        if (key_exists('tel', $parameters)) $user->tel = $parameters['tel'];
        if (key_exists('headimgurl', $parameters)) $user->headimgurl = $parameters['headimgurl'];
        if (key_exists('ip', $parameters)) $user->ip = $parameters['ip'];
        if (key_exists('state', $parameters)) $user->state = $parameters['state'];
        if (key_exists('role_id', $parameters)) {
            $user->detachRoles($user->roles);
            $user->attachRole(Role::find($parameters['role_id']));
        }
        if (!$user->save()) $this->response->errorInternal(500001);
        $user = User::find($parameters['id']);
        $user->roles;
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('users/user/remove')) $this->response->errorForbidden(403031);

        if (Validator::make(['id' => $id], ['id' => 'exists:users'])->fails()) $this->response->errorBadRequest(400020);

        $user = User::find($id);
        $user->detachRoles($user->roles);
        return $user->delete();
    }
}
