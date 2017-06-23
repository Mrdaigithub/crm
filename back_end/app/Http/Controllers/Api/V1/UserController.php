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
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {
        $users = User::all();
        foreach ($users as $user){
            $user->roles;
        }
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|max:10|unique:users|string',
            'password' => 'required|min:4|max:20|string',
            'tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/'],
            'headimgurl' => ['regex:/^https?:\/\/(([a-zA-Z0-9_-])+(\.)?)*(:\d+)?(\/((\.)?(\?)?=?&?[a-zA-Z0-9_-](\?)?)*)*\.{1}(png|jpg|bmp|gif)$/'],
            'ip' => 'ip',
            'role_id' => 'required|exists:roles,id',
            'state' => 'boolean'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $user = new User();
        $user->username = $parameters['username'];
        $user->password = bcrypt($parameters['password']);
        if (key_exists('tel', $parameters)) $user->tel = $parameters['tel'];
        if (key_exists('headimgurl', $parameters)) $user->headimgurl = $parameters['headimgurl'];
        if (key_exists('ip', $parameters)) $user->ip = $parameters['ip'];
        if (key_exists('state', $parameters)) $user->state = $parameters['state'];
        if (!$user->save()) $this->response->errorInternal();
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
        $parameters = [
            'id' => $id
        ];
        $validator = Validator::make($parameters, [
            'id' => 'numeric'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        if ($id == 0) {
            $user = JWTAuth::parseToken()->authenticate();
            return $user;
        }

        $validator = Validator::make($parameters, [
            'id' => 'numeric|exists:users'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $user = User::find($id);
        return $user;
    }

    /**
     * Display users by role id.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show_by_rid($id)
    {
        $parameters = [
            'id' => $id
        ];
        $validator = Validator::make($parameters, [
            'id' => 'numeric|exists:roles'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $role = Role::find($id);
        $users = $role->users;
        return $users;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $parameters = $request->all();
        $parameters['id'] = $id;
        $validator = Validator::make($parameters, [
            'id' => 'numeric|exists:users',
            'username' => 'min:4|max:10|unique:users|string',
            'password' => 'min:4|max:20|string',
            'tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/'],
            'headimgurl' => ['regex:/^https?:\/\/(([a-zA-Z0-9_-])+(\.)?)*(:\d+)?(\/((\.)?(\?)?=?&?[a-zA-Z0-9_-](\?)?)*)*\.{1}(png|jpg|bmp|gif)$/'],
            'ip' => 'ip',
            'state' => 'boolean',
            'role_id' => 'exists:roles,id'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();
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
        if (!$user->save()) $this->response->errorInternal();
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
        $parameters = [
            'id' => $id
        ];
        $validator = Validator::make($parameters, [
            'id' => 'numeric|exists:users'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $user = User::find($id);
        $user->detachRoles($user->roles);
        return $user->delete();
    }
}
