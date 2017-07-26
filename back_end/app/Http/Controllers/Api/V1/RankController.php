<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use Dingo\Api\Routing\Helpers;

class RankController extends Controller
{
    use Helpers;

    /**
     * Display the specified resource.
     *
     * @param  int $type
     * @return \Illuminate\Http\Response
     */
    public function show($type)
    {
        $res = [];
        $users = User::all();

        if ($type === 'advisory') {
            foreach ($users as $user) {
                $item['patient_len'] = count($user->patient);
                $item['username'] = $user->username;
                $item['user_id'] = $user->id;
                array_push($res, $item);
            }
        } elseif ($type === 'arrive') {
            foreach ($users as $user) {
                if (count($user->patient) > 0) {
                    $i = 0;
                    foreach ($user->patient as $patient) {
                        if ($patient->state === 2) $i++;
                    }
                    $item['patient_len'] = $i;
                } else {
                    $item['patient_len'] = count($user->patient);
                }
                $item['username'] = $user->username;
                $item['user_id'] = $user->id;
                array_push($res, $item);
            }
        } elseif ($type === 'lose') {
            foreach ($users as $user) {
                if (count($user->patient) > 0) {
                    $i = 0;
                    foreach ($user->patient as $patient) {
                        if ($patient->state !== 2) $i++;
                    }
                    $item['patient_len'] = $i;
                } else {
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
}
