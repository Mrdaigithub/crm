<?php

namespace App\Http\Controllers\Api\V1\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Management\Doctor;
use Validator;
use Dingo\Api\Routing\Helpers;

class DoctorsController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Doctor::all();
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
                'name' => 'string|unique:doctors'
            ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $doctor = new Doctor();
        $doctor->name = $name;
        if (!$doctor->save()) $this->response->errorInternal();
        return $doctor;
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
            'id' => 'numeric|exists:doctors',
            'name' => 'unique:doctors|string',
            'state' => 'boolean',
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $doctor = Doctor::find($id);
        if (key_exists('name', $parameters)) $doctor->name = $parameters['name'];
        if (key_exists('state', $parameters)) $doctor->state = $parameters['state'];
        if (!$doctor->save()) $this->response->errorInternal();
        return $doctor;
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
                'id' => 'numeric|exists:doctors',
            ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $doctor = Doctor::find($id);
        if (!$doctor->delete()) $this->response->errorInternal();
        return;
    }
}
