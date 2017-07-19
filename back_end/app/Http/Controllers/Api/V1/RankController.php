<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use DB;
use function PHPSTORM_META\type;
use Validator;
use Dingo\Api\Routing\Helpers;

class RankController extends Controller
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
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function show($type)
    {
        $res = [];
        $users = User::all();

        if ($type === 'advisory') {
            foreach ($users as $user){
                $item['patient_len'] = count($user->patient);
                $item['username'] = $user->username;
                $item['user_id'] = $user->id;
                array_push($res, $item);
            }
        }
        elseif ($type === 'arrive') {
            foreach ($users as $user){
                if (count($user->patient) > 0){
                    $i = 0;
                    foreach ($user->patient as $patient) {
                        if ($patient->state === 2) $i++;
                    }
                    $item['patient_len'] = $i;
                }else {
                    $item['patient_len'] = count($user->patient);
                }
                $item['username'] = $user->username;
                $item['user_id'] = $user->id;
                array_push($res, $item);
            }
        }
        elseif ($type === 'lose') {
            foreach ($users as $user){
                if (count($user->patient) > 0){
                    $i = 0;
                    foreach ($user->patient as $patient) {
                        if ($patient->state !== 2) $i++;
                    }
                    $item['patient_len'] = $i;
                }else {
                    $item['patient_len'] = count($user->patient);
                }
                $item['username'] = $user->username;
                $item['user_id'] = $user->id;
                array_push($res, $item);
            }
        }
        rsort($res);
        return $res;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
