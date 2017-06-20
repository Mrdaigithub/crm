<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Http\Controllers\Controller;
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
        $role = new Role();
        return $role->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($name)
    {
        $parameters = [
            'name' => $name
        ];
        $validator = Validator::make($parameters, [
            'name' => 'unique:roles|string'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();
        $role = new Role();
        $role->name = $name;
        if (!$role->save()) $this->response->errorInternal();
        return $role;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $name)
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
        //
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
            'id' => 'numeric|exists:roles',
            'name' => 'required|string|unique:roles'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();
        $role = Role::find($id);
        $role->name = $parameters['name'];
        if (!$role->save()) $this->response->errorInternal();
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
        $parameters = [
            'id' => $id
        ];
        $validator = Validator::make($parameters, [
            'id' => 'numeric'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();
        if (!Role::destroy($id)) $this->response->errorBadRequest();
    }
}
