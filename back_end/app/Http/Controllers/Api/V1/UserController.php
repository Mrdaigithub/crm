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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request['name'];
        $permission->description = $request['description'];
        $permission->save();

        $role = Role::where('id', 1)->first();

        $role->attachPermission($permission);
        return $permission;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|max:10|unique:users|string',
            'password' => 'required|min:4|max:20|string',
            'tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/'],
            'role_id' => 'required|exists:roles,id'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();
        $user = new User();
        $user->username = $request->get('username');
        $user->password = Hash::make($request->get('password'));
        $user->tel = $request->get('tel');
        if (!$user->save()) $this->response->errorInternal();
        $role = Role::where('id',$request->get('role_id'))->first();
        $user->attachRole($role);
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id == 0){
            $user = JWTAuth::parseToken()->authenticate();
            return $user;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
