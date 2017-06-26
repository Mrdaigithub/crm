<?php

namespace App\Http\Controllers\Api\V1\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Management\Channel;
use Validator;
use Dingo\Api\Routing\Helpers;

class ChannelController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = new Channel();
        return $channels->all();
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
        $validator = validator::make(
            [
                'name' => $request['name'],
                'state' => $request['state'],
            ],
            [
                'name' => 'required|string|unique:roles',
                'state' => 'boolean',
            ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $channel = new Channel();
        $channel->name = $request['name'];
<<<<<<< HEAD
        if (array_key_exists('state', $request)) $channel->state = $request['state'];
=======
        $channel->state = $request['state'];
>>>>>>> dad4ece71b723027a31316569c1b58d4dad1dd74
        if (!$channel->save()) $this->response->errorInternal();
        return $channel;
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
            'id' => 'numeric|exists:channels',
            'name' => 'unique:channels|string',
            'state' => 'boolean',
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $channel = Channel::find($id);
        if (key_exists('name', $parameters)) $channel->name = $parameters['name'];
        if (key_exists('state', $parameters)) $channel->state = $parameters['state'];
        if (!$channel->save()) $this->response->errorInternal();
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
        $validator = validator::make(
            [
                'id' => $id,
            ],
            [
                'id' => 'numeric|exists:channels',
            ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $channel = Channel::find($id);
        if (!$channel->delete()) $this->response->errorInternal();
        return;
    }
}
