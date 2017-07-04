<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use DB;
use Validator;
use Dingo\Api\Routing\Helpers;

class PatientController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patient_paginate = Patient::paginate(5)->toArray();
        $patient_paginate['data'] = array_map(function ($e) {
            $e['user'] = Patient::find($e['id'])->user;
            $e['user'] = $e['user']->toArray();
            return $e;
        }, $patient_paginate['data']);
        return $patient_paginate;
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
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'name' => 'required|string',
            'sex' => 'boolean',
            'age' => 'numeric',
            'tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/'],
            'wechat' => 'string',
            'state' => 'required|numeric',
            'keyword' => 'string',
            'pageurl' => 'url',
            'mark' => 'string',
            'price' => 'numeric',
            'advisory_date' => 'required|date',
            'arrive_date' => 'required|date',
            'advisory_id' => 'required|numeric|exists:advisories,id',
            'channel_id' => 'required|numeric|exists:channels,id',
            'disease_id' => 'required|numeric|exists:diseases,id',
            'doctor_id' => 'required|numeric|exists:doctors,id',
            'user_id' => 'required|numeric|exists:users,id'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $patient = new Patient();
        $patient->name = $parameters['name'];
        $patient->tel = $parameters['tel'];
        $patient->state = $parameters['state'];
        $patient->advisory_date = $parameters['advisory_date'];
        $patient->arrive_date = $parameters['arrive_date'];
        if (array_key_exists('sex', $parameters)) $patient->sex = $parameters['name'];
        if (array_key_exists('age', $parameters)) $patient->age = $parameters['age'];
        if (array_key_exists('wechat', $parameters)) $patient->wechat = $parameters['wechat'];
        if (array_key_exists('keyword', $parameters)) $patient->keyword = $parameters['keyword'];
        if (array_key_exists('pageurl', $parameters)) $patient->pageurl = $parameters['pageurl'];
        if (array_key_exists('mark', $parameters)) $patient->mark = $parameters['mark'];
        if (array_key_exists('price', $parameters)) $patient->price = $parameters['price'];
        if (!$patient->save()) $this->response->errorInternal();

        $patient->user()->attach($parameters['user_id']);
        $patient->advisory()->attach($parameters['advisory_id']);
        $patient->channel()->attach($parameters['channel_id']);
        $patient->disease()->attach($parameters['disease_id']);
        $patient->doctor()->attach($parameters['doctor_id']);

        $patient_res = $patient->toArray();
        $patient_res['user'] = $patient->user;
        $patient_res['advisory'] = $patient->advisory;
        $patient_res['channel'] = $patient->channel;
        $patient_res['disease'] = $patient->disease;
        $patient_res['doctor'] = $patient->doctor;
        return $patient_res;
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
            'id' => 'numeric|exists:patients',
            'name' => 'string',
            'sex' => 'boolean',
            'age' => 'numeric',
            'tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/'],
            'wechat' => 'string',
            'state' => 'numeric',
            'keyword' => 'string',
            'pageurl' => 'url',
            'mark' => 'string',
            'price' => 'numeric',
            'advisory_date' => 'date',
            'arrive_date' => 'date',
            'advisory_id' => 'numeric|exists:advisories,id',
            'channel_id' => 'numeric|exists:channels,id',
            'disease_id' => 'numeric|exists:diseases,id',
            'doctor_id' => 'numeric|exists:doctors,id',
            'user_id' => 'numeric|exists:users,id'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

        $patient = Patient::find($parameters['id']);
        if (key_exists('name', $parameters)) $patient->name = $parameters['name'];
        if (key_exists('sex', $parameters)) $patient->sex = $parameters['sex'];
        if (key_exists('age', $parameters)) $patient->age = $parameters['age'];
        if (key_exists('tel', $parameters)) $patient->tel = $parameters['tel'];
        if (key_exists('wechat', $parameters)) $patient->wechat = $parameters['wechat'];
        if (key_exists('state', $parameters)) $patient->state = $parameters['state'];
        if (key_exists('keyword', $parameters)) $patient->keyword = $parameters['keyword'];
        if (key_exists('pageurl', $parameters)) $patient->pageurl = $parameters['pageurl'];
        if (key_exists('mark', $parameters)) $patient->mark = $parameters['mark'];
        if (key_exists('price', $parameters)) $patient->price = $parameters['price'];
        if (key_exists('advisory_date', $parameters)) $patient->advisory_date = $parameters['advisory_date'];
        if (key_exists('arrive_date', $parameters)) $patient->arrive_date = $parameters['arrive_date'];
        if (key_exists('advisory_id', $parameters)) DB::update('update patient_advisory set advisory_id = ? where patient_id = ?',[$parameters['advisory_id'], $parameters['id']]);
        if (key_exists('channel_id', $parameters)) DB::update('update patient_channel set channel_id = ? where patient_id = ?',[$parameters['channel_id'], $parameters['id']]);
        if (key_exists('disease_id', $parameters)) DB::update('update patient_disease set disease_id = ? where patient_id = ?',[$parameters['disease_id'], $parameters['id']]);
        if (key_exists('doctor_id', $parameters)) DB::update('update patient_doctor set doctor_id = ? where patient_id = ?',[$parameters['doctor_id'], $parameters['id']]);
        if (key_exists('user_id', $parameters)) DB::update('update patient_user set user_id = ? where patient_id = ?',[$parameters['user_id'], $parameters['id']]);
        $patient->advisory;
        $patient->channel;
        $patient->disease;
        $patient->doctor;
        $patient->user;
        if (!$patient->save()) $this->response->errorInternal();
        return response()->json($patient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator = validator::make(['id' => $id,], [
            'id' => 'numeric|exists:patients',
        ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        if (!Patient::find($id)->delete()) $this->response->errorInternal();
        return;
    }
}
