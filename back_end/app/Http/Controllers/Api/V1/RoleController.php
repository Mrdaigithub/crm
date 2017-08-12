<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Http\Controllers\Controller;
use JWTAuth, JWTException;
use Validator;
use Dingo\Api\Routing\Helpers;

class RoleController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function create($name)
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('users/role/add')) $this->response->errorForbidden(403026);

        if (Validator::make(['name' => $name], ['name' => 'string'])->fails()) $this->response->errorBadRequest(400000);
        if (Validator::make(['name' => $name], ['name' => 'unique:roles'])->fails()) $this->response->errorBadRequest(400001);

        $role = new Role();
        $role->name = $name;
        if (!$role->save()) $this->response->errorInternal(500001);
        return $role;
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
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('users/role/edit')) $this->response->errorForbidden(403028);

        $parameters = $request->all();
        $parameters['id'] = $id;
        if (Validator::make($parameters, ['id' => 'numeric'])->fails()) $this->response->errorBadRequest(400002);
        if (Validator::make($parameters, ['id' => 'exists:roles'])->fails()) $this->response->errorBadRequest(400003);
        if (Validator::make($parameters, ['name' => 'required'])->fails()) $this->response->errorBadRequest(400004);
        if (Validator::make($parameters, ['name' => 'string'])->fails()) $this->response->errorBadRequest(400000);
        if (Validator::make($parameters, ['name' => 'unique:roles'])->fails()) $this->response->errorBadRequest(400001);

        $role = Role::find($id);
        $role->name = $parameters['name'];
        if (!$role->save()) $this->response->errorInternal(500001);
        return $role;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('users/role/remove')) $this->response->errorForbidden(403027);

        if (Validator::make(['id' => $id], ['id' => 'numeric'])->fails()) $this->response->errorBadRequest(400002);
        if (Validator::make(['id' => $id], ['id' => 'exists:roles'])->fails()) $this->response->errorBadRequest(400003);

        $role = Role::find($id);
        if (count($role->users)) $this->response->errorInternal(500002);
        Role::find($id)->detachPermissions();
        Role::destroy($id);
    }
}
