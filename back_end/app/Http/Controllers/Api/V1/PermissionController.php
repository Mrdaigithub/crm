<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Validator;
use Dingo\Api\Routing\Helpers;

class PermissionController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parameters = [
            'id' => $id
        ];
        $validator = validator::make($parameters, [
            'id' => 'numeric|exists:roles'
        ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $role = Role::find($id);
        $permission_list = permission::all();
        foreach ($permission_list as $permission) {
            if ($role->hasPermission($permission['name'])) $permission['selected'] = true;
            else $permission['selected'] = false;
        }
        return response()->json($permission_list);
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
        $parameters = [
            'id' => $id
        ];
        $validator = validator::make($parameters, [
            'id' => 'numeric|exists:roles'
        ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $role = Role::find($id);
        $permission_list = $request->all()['permissions'];

        foreach ($permission_list as $permission) {
            if ($role->hasPermission($permission['name']) && $permission['selected'] === 'false') {
                $role->detachPermission(Permission::find($permission['id']));
                $permission['selected'] = false;
            }
            if (!$role->hasPermission($permission['name']) && $permission['selected'] === 'true'){
                $role->attachPermission(Permission::find($permission['id']));
                $permission['selected'] = true;
            }
        }
        return response()->json($permission_list);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
