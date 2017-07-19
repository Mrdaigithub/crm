<?php

namespace App\Http\Controllers\Api\V1\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Management\Disease;
use App\Models\Management\Channel;
use App\Models\Management\Advisory;
use Validator;
use Dingo\Api\Routing\Helpers;

class GroupController extends Controller
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
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $res = [];
        if ($name === 'user') {
            $users = User::all();
            foreach ($users as $user) {
                $item['id'] = $user['id'];
                $item['name'] = $user['username'];
                $item['advisory_len'] = count($user->patient);
                $item['arrive_len'] = 0;
                $item['lose_len'] = 0;
                foreach ($user->patient as $patient) {
                    if ($patient['state'] === 2) {
                        $item['arrive_len']++;
                    }else{
                        $item['lose_len']++;
                    }
                }
                array_push($res, $item);
            }
        }
        elseif ($name === 'disease') {
            $diseases = Disease::all();
            foreach ($diseases as $disease) {
                $item['id'] = $disease['id'];
                $item['name'] = $disease['name'];
                $item['advisory_len'] = count($disease->patient);
                $item['arrive_len'] = 0;
                $item['lose_len'] = 0;
                foreach ($disease->patient as $patient) {
                    if ($patient['state'] === 2) {
                        $item['arrive_len']++;
                    }else{
                        $item['lose_len']++;
                    }
                }
                array_push($res, $item);
            }
        }
        elseif ($name === 'channel') {
            $channels = Channel::all();
            foreach ($channels as $channel) {
                $item['id'] = $channel['id'];
                $item['name'] = $channel['name'];
                $item['advisory_len'] = count($channel->patient);
                $item['arrive_len'] = 0;
                $item['lose_len'] = 0;
                foreach ($channel->patient as $patient) {
                    if ($patient['state'] === 2) {
                        $item['arrive_len']++;
                    }else{
                        $item['lose_len']++;
                    }
                }
                array_push($res, $item);
            }
        }
        elseif ($name === 'advisory') {
            $advisories = Advisory::all();
            foreach ($advisories as $advisory) {
                $item['id'] = $advisory['id'];
                $item['name'] = $advisory['name'];
                $item['advisory_len'] = count($advisory->patient);
                $item['arrive_len'] = 0;
                $item['lose_len'] = 0;
                foreach ($advisory->patient as $patient) {
                    if ($patient['state'] === 2) {
                        $item['arrive_len']++;
                    }else{
                        $item['lose_len']++;
                    }
                }
                array_push($res, $item);
            }
        }
        return $res;
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
        //
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
