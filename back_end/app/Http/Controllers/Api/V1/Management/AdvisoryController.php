<?php

namespace App\Http\Controllers\Api\V1\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Management\Advisory;
use Validator;
use Dingo\Api\Routing\Helpers;

class AdvisoryController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Advisory::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function create($name)
    {
        $validator = validator::make(
            [
                'name' => $name,
            ],
            [
                'name' => 'string|unique:advisories'
            ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $advisory = new Advisory();
        $advisory->name = $name;
        if (!$advisory->save()) $this->response->errorInternal();
        return $advisory;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $parameters = $request->all();
        $parameters['id'] = $id;
        $validator = Validator::make($parameters, [
            'id' => 'numeric|exists:advisories',
            'name' => 'string|unique:advisories',
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $advisory = Advisory::find($id);
        if (key_exists('name', $parameters)) $advisory->name = $parameters['name'];
        if (!$advisory->save()) $this->response->errorInternal();
        return $advisory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator = validator::make(
            [
                'id' => $id,
            ],
            [
                'id' => 'numeric|exists:advisories',
            ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $advisory = Advisory::find($id);
        if (!$advisory->delete()) $this->response->errorInternal();
        return;
    }
}
