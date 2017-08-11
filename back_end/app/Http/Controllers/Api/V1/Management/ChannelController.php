<?php

namespace App\Http\Controllers\Api\V1\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth, JWTException;
use App\Models\Management\Channel;
use Validator;
use Dingo\Api\Routing\Helpers;

class ChannelController extends Controller
{
    use Helpers;

    function __construct()
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('allow_info_module')) $this->response->errorForbidden(403012);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Channel::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('info/channel/add')) $this->response->errorForbidden(403019);

        if (Validator::make(['name' => $request['name']], ['name' => 'required'])->fails()) $this->response->errorBadRequest(400027);
        if (Validator::make(['name' => $request['name']], ['name' => 'string'])->fails()) $this->response->errorBadRequest(400028);
        if (Validator::make(['name' => $request['name']], ['name' => 'unique:channels'])->fails()) $this->response->errorBadRequest(400029);

        $channel = new Channel();
        $channel->name = $request['name'];
        if (!$channel->save()) $this->response->errorInternal(500001);
        return $channel;
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
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('info/channel/edit')) $this->response->errorForbidden(403021);

        $parameters = $request->all();
        $parameters['id'] = $id;
        if (Validator::make($parameters, ['id' => 'exists:channels'])->fails()) $this->response->errorBadRequest(400030);
        if (Validator::make($parameters, ['name' => 'string'])->fails()) $this->response->errorBadRequest(400028);
        if (Validator::make($parameters, ['name' => 'unique:channels'])->fails()) $this->response->errorBadRequest(400029);
        if (Validator::make($parameters, ['state' => 'boolean'])->fails()) $this->response->errorBadRequest(400031);

        $channel = Channel::find($id);
        if (key_exists('name', $parameters)) $channel->name = $parameters['name'];
        if (key_exists('state', $parameters)) $channel->state = $parameters['state'];
        if (!$channel->save()) $this->response->errorInternal(500001);
        return $channel;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('info/channel/remove')) $this->response->errorForbidden(403020);

        if (Validator::make(['id' => $id], ['id' => 'exists:channels'])->fails()) $this->response->errorBadRequest(400030);
        Channel::find($id)->delete();
    }
}
