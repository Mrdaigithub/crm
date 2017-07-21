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
        if (Validator::make(['name' => $name], ['name' => 'string'])->fails()) $this->response->errorBadRequest(400032);
        if (Validator::make(['name' => $name], ['name' => 'unique:advisories'])->fails()) $this->response->errorBadRequest(400033);

        $advisory = new Advisory();
        $advisory->name = $name;
        if (!$advisory->save()) $this->response->errorInternal(500001);
        return $advisory;
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
        if (Validator::make($parameters, ['id' => 'exists:advisories'])->fails()) $this->response->errorBadRequest(400034);
        if (Validator::make($parameters, ['name' => 'string'])->fails()) $this->response->errorBadRequest(400032);
        if (Validator::make($parameters, ['name' => 'unique:advisories'])->fails()) $this->response->errorBadRequest(400033);

        $advisory = Advisory::find($id);
        if (key_exists('name', $parameters)) $advisory->name = $parameters['name'];
        if (!$advisory->save()) $this->response->errorInternal(500001);
        return $advisory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Validator::make(['id' => $id], ['id' => 'exists:advisories'])->fails()) $this->response->errorBadRequest(400034);

        $advisory = Advisory::find($id);
        $advisory->delete();
    }
}
