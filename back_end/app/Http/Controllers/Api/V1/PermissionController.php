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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validator = validator::make(['id' => $id], [
            'id' => 'numeric|exists:roles'
        ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $role = Role::find($id);
        $permission = new Permission();
        $res =
            $permission
                ->where('depth', 1)
                ->get()
                ->map(function ($item) use ($role, $permission) {
                    $item->children =
                        $item
                            ->where('parentid', $item->id)
                            ->get()
                            ->map(function ($c_item) use ($role, $permission) {
                                $c_item->state = $role->hasPermission($c_item->name);
                                return $c_item;
                            });
                    return $item;
                });
        return $res->all();
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
            if (!$role->hasPermission($permission['name']) && $permission['selected'] === 'true') {
                $role->attachPermission(Permission::find($permission['id']));
                $permission['selected'] = true;
            }
        }
        return response()->json($permission_list);
    }
}
