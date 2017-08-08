<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
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
        if (Validator::make(['id' => $id], ['id' => 'numeric'])->fails()) $this->response->errorBadRequest(400000);
        if (Validator::make(['id' => $id], ['id' => 'exists:roles'])->fails()) $this->response->errorBadRequest(400003);

        $role = Role::find($id);
        $permission = new Permission();
        $res = $permission->where('depth', 1)->get()->map(function ($item) use ($role, $permission) {
            $item->state = $role->hasPermission($item->name);
            $item->children = $item->where('parentid', $item->id)->get()->map(function ($c_item) use ($role, $permission) {
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
        if (Validator::make(['id' => $id], ['id' => 'numeric'])->fails()) $this->response->errorBadRequest(400000);
        if (Validator::make(['id' => $id], ['id' => 'exists:roles'])->fails()) $this->response->errorBadRequest(400003);
        if (!key_exists('permissions', $request->all())) $this->response->errorBadRequest(401010);

        $role = Role::find($id);
        $permission = new Permission();
        $permissions = collect($request->only('permissions')['permissions']);
        collect($permissions)->each(function ($item) use ($role, $permission) {
            if (count($item['children'])) {
                foreach ($item['children'] as $child) {
                    if ($child['state'] && !$role->hasPermission($child['name'])) $role->attachPermission($child['id']);
                    if (!$child['state'] && $role->hasPermission($child['name'])) $role->detachPermission($child['id']);
                }
            }
        });
        return $this->show($id);
    }
}
