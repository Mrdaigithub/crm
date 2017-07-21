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
        if (Validator::make(['name' => $name], ['name' => 'string'])->fails()) $this->response->errorBadRequest(400023);
        if (Validator::make(['name' => $name], ['name' => 'unique:doctors'])->fails()) $this->response->errorBadRequest(400024);

        $doctor = new Doctor();
        $doctor->name = $name;
        if (!$doctor->save()) $this->response->errorInternal(500001);
        return $doctor;
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
        if (Validator::make($parameters, ['id' => 'exists:doctors'])->fails()) $this->response->errorBadRequest(400025);
        if (Validator::make($parameters, ['name' => 'string'])->fails()) $this->response->errorBadRequest(400023);
        if (Validator::make($parameters, ['name' => 'unique:doctors'])->fails()) $this->response->errorBadRequest(400024);
        if (Validator::make($parameters, ['state' => 'boolean'])->fails()) $this->response->errorBadRequest(400026);

        $doctor = Doctor::find($id);
        if (key_exists('name', $parameters)) $doctor->name = $parameters['name'];
        if (key_exists('state', $parameters)) $doctor->state = $parameters['state'];
        if (!$doctor->save()) $this->response->errorInternal(500001);
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
        if (Validator::make(['id' => $id], ['id' => 'exists:doctors'])->fails()) $this->response->errorBadRequest(400025);

        $doctor = Doctor::find($id);
        $doctor->delete();
    }
}
