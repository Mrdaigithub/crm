<?php

namespace App\Http\Controllers\Api\V1;

use JWTAuth, JWTException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use DB;
use Dingo\Api\Routing\Helpers;

class PatientController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('patients/info/get')) $this->response->errorForbidden(403002);
        $parameters = $request->all();
        $parameters['page'] = array_key_exists('page', $parameters) ? $parameters['page'] : 1;
        $parameters['limit'] = array_key_exists('limit', $parameters) ? $parameters['limit'] : 10;
        $parameters['sortby'] = array_key_exists('sortby', $parameters) ? $parameters['sortby'] : 'id';
        $parameters['order'] = array_key_exists('order', $parameters) ? $parameters['order'] : 'asc';
        $patient_paginate = Patient::orderBy($parameters['sortby'], $parameters['order'])->paginate($parameters['limit']);
//        $patient_paginate = collect($patient_paginate);
//        $patient_paginate = $patient_paginate->map(function ($item) {
//           $item->user = $item->user;
//           $item->disease = $item->disease;
//           $item->doctor = $item->doctor;
//           $item->channel = $item->channel;
//           $item->advisory = $item->advisory;
//           return $item;
//        });
//        $patient_paginate['data'] = collect($patient_paginate['data'])->map(function ($item) {
//            $item->user = collect($item)->user;
//            return $item;
//        });
//        print_r($patient_paginate['data']);
//        $patient_paginate = $patient_paginate->paginate($parameters['limit']);
//        return $patient_paginate;
//        $patient_paginate = Patient::orderBy($parameters['sortby'], $parameters['order'])->paginate($parameters['limit']);
//        $patient_paginate['data'] = array_map(function ($e) {
//            $props = ['user', 'disease', 'doctor', 'channel', 'advisory'];
//            foreach ($props as $prop) {
//                $item = Patient::find($e['id'])[$prop];
//                if (count($item->toArray())) $e[$prop] = $item->toArray()[0];
//                else {
//                    if ($prop === 'user') $e[$prop] = ['id' => '', 'username' => ''];
//                    else $e[$prop] = ['id' => '', 'name' => ''];
//                }
//            }
//            return $e;
//        }, $patient_paginate['data']);
        return $patient_paginate;
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

        if (Validator::make($parameters, ['name' => 'required'])->fails()) $this->response->errorBadRequest(400035);
        if (Validator::make($parameters, ['name' => 'string'])->fails()) $this->response->errorBadRequest(400036);
        if (Validator::make($parameters, ['sex' => 'boolean'])->fails()) $this->response->errorBadRequest(400037);
        if (Validator::make($parameters, ['age' => 'numeric'])->fails()) $this->response->errorBadRequest(400038);
        if (Validator::make($parameters, ['tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/']])->fails()) $this->response->errorBadRequest(400039);
        if (Validator::make($parameters, ['wechat' => 'string'])->fails()) $this->response->errorBadRequest(400040);
        if (Validator::make($parameters, ['state' => 'numeric'])->fails()) $this->response->errorBadRequest(400041);
        if (Validator::make($parameters, ['keyword' => 'string'])->fails()) $this->response->errorBadRequest(400042);
        if (Validator::make($parameters, ['pageurl' => 'url'])->fails()) $this->response->errorBadRequest(400043);
        if (Validator::make($parameters, ['mark' => 'string'])->fails()) $this->response->errorBadRequest(400044);
        if (Validator::make($parameters, ['price' => 'numeric'])->fails()) $this->response->errorBadRequest(400045);
        if (Validator::make($parameters, ['first' => 'boolean'])->fails()) $this->response->errorBadRequest(400046);
        if (Validator::make($parameters, ['advisory_date' => 'required'])->fails()) $this->response->errorBadRequest(400047);
        if (Validator::make($parameters, ['advisory_date' => 'date'])->fails()) $this->response->errorBadRequest(400048);
        if (Validator::make($parameters, ['arrive_date' => 'date'])->fails()) $this->response->errorBadRequest(400049);
        if (Validator::make($parameters, ['advisory_id' => 'required'])->fails()) $this->response->errorBadRequest(400050);
        if (Validator::make($parameters, ['advisory_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400051);
        if (Validator::make($parameters, ['advisory_id' => 'exists:advisories,id'])->fails()) $this->response->errorBadRequest(400052);
        if (Validator::make($parameters, ['channel_id' => 'required'])->fails()) $this->response->errorBadRequest(400053);
        if (Validator::make($parameters, ['channel_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400054);
        if (Validator::make($parameters, ['channel_id' => 'exists:channels,id'])->fails()) $this->response->errorBadRequest(400055);
        if (Validator::make($parameters, ['disease_id' => 'required'])->fails()) $this->response->errorBadRequest(400056);
        if (Validator::make($parameters, ['disease_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400057);
        if (Validator::make($parameters, ['disease_id' => 'exists:diseases,id'])->fails()) $this->response->errorBadRequest(400058);
        if (Validator::make($parameters, ['doctor_id' => 'required'])->fails()) $this->response->errorBadRequest(400059);
        if (Validator::make($parameters, ['doctor_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400060);
        if (Validator::make($parameters, ['doctor_id' => 'exists:doctors,id'])->fails()) $this->response->errorBadRequest(400061);
        if (Validator::make($parameters, ['user_id' => 'required'])->fails()) $this->response->errorBadRequest(400062);
        if (Validator::make($parameters, ['user_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400063);
        if (Validator::make($parameters, ['user_id' => 'exists:users,id'])->fails()) $this->response->errorBadRequest(400064);

        $patient = new Patient();
        $patient->name = $parameters['name'];
        $patient->tel = $parameters['tel'];
        $patient->state = $parameters['state'];
        $patient->advisory_date = $parameters['advisory_date'];
        if (array_key_exists('sex', $parameters)) $patient->sex = $parameters['name'];
        if (array_key_exists('age', $parameters)) $patient->age = $parameters['age'];
        if (array_key_exists('wechat', $parameters)) $patient->wechat = $parameters['wechat'];
        if (array_key_exists('keyword', $parameters)) $patient->keyword = $parameters['keyword'];
        if (array_key_exists('pageurl', $parameters)) $patient->pageurl = $parameters['pageurl'];
        if (array_key_exists('mark', $parameters)) $patient->mark = $parameters['mark'];
        if (array_key_exists('price', $parameters)) $patient->price = $parameters['price'];
        if (array_key_exists('first', $parameters)) $patient->first = $parameters['first'];
        if (array_key_exists('arrive_date', $parameters)) $patient->arrive_date = $parameters['arrive_date'];
        if (!$patient->save()) $this->response->errorInternal(500001);

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

        if (Validator::make($parameters, ['id' => 'numeric'])->fails()) $this->response->errorBadRequest(400065);
        if (Validator::make($parameters, ['id' => 'exists:patients'])->fails()) $this->response->errorBadRequest(400066);
        if (Validator::make($parameters, ['name' => 'string'])->fails()) $this->response->errorBadRequest(400036);
        if (Validator::make($parameters, ['sex' => 'boolean'])->fails()) $this->response->errorBadRequest(400037);
        if (Validator::make($parameters, ['age' => 'numeric'])->fails()) $this->response->errorBadRequest(400038);
        if (Validator::make($parameters, ['tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/']])->fails()) $this->response->errorBadRequest(400039);
        if (Validator::make($parameters, ['wechat' => 'string'])->fails()) $this->response->errorBadRequest(400040);
        if (Validator::make($parameters, ['state' => 'numeric'])->fails()) $this->response->errorBadRequest(400041);
        if (Validator::make($parameters, ['keyword' => 'string'])->fails()) $this->response->errorBadRequest(400042);
        if (Validator::make($parameters, ['pageurl' => 'url'])->fails()) $this->response->errorBadRequest(400043);
        if (Validator::make($parameters, ['mark' => 'string'])->fails()) $this->response->errorBadRequest(400044);
        if (Validator::make($parameters, ['price' => 'numeric'])->fails()) $this->response->errorBadRequest(400045);
        if (Validator::make($parameters, ['first' => 'boolean'])->fails()) $this->response->errorBadRequest(400046);
        if (Validator::make($parameters, ['advisory_date' => 'date'])->fails()) $this->response->errorBadRequest(400048);
        if (Validator::make($parameters, ['arrive_date' => 'date'])->fails()) $this->response->errorBadRequest(400049);
        if (Validator::make($parameters, ['advisory_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400051);
        if (Validator::make($parameters, ['advisory_id' => 'exists:advisories,id'])->fails()) $this->response->errorBadRequest(400052);
        if (Validator::make($parameters, ['channel_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400054);
        if (Validator::make($parameters, ['channel_id' => 'exists:channels,id'])->fails()) $this->response->errorBadRequest(400055);
        if (Validator::make($parameters, ['disease_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400057);
        if (Validator::make($parameters, ['disease_id' => 'exists:diseases,id'])->fails()) $this->response->errorBadRequest(400058);
        if (Validator::make($parameters, ['doctor_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400060);
        if (Validator::make($parameters, ['doctor_id' => 'exists:doctors,id'])->fails()) $this->response->errorBadRequest(400061);
        if (Validator::make($parameters, ['user_id' => 'numeric'])->fails()) $this->response->errorBadRequest(400063);
        if (Validator::make($parameters, ['user_id' => 'exists:users,id'])->fails()) $this->response->errorBadRequest(400064);

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
        if (key_exists('first', $parameters)) $patient->first = $parameters['first'];
        if (key_exists('advisory_date', $parameters)) $patient->advisory_date = $parameters['advisory_date'];
        if (key_exists('arrive_date', $parameters)) $patient->arrive_date = $parameters['arrive_date'];
        if (key_exists('advisory_id', $parameters)) DB::update('update patient_advisory set advisory_id = ? where patient_id = ?', [$parameters['advisory_id'], $parameters['id']]);
        if (key_exists('channel_id', $parameters)) DB::update('update patient_channel set channel_id = ? where patient_id = ?', [$parameters['channel_id'], $parameters['id']]);
        if (key_exists('disease_id', $parameters)) DB::update('update patient_disease set disease_id = ? where patient_id = ?', [$parameters['disease_id'], $parameters['id']]);
        if (key_exists('doctor_id', $parameters)) DB::update('update patient_doctor set doctor_id = ? where patient_id = ?', [$parameters['doctor_id'], $parameters['id']]);
        if (key_exists('user_id', $parameters)) DB::update('update patient_user set user_id = ? where patient_id = ?', [$parameters['user_id'], $parameters['id']]);
        $patient->advisory;
        $patient->channel;
        $patient->disease;
        $patient->doctor;
        $patient->user;
        if (!$patient->save()) $this->response->errorInternal();
        return response()->json($patient);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $validator = validator::make(['name' => $name], [
            'name' => 'string'
        ]);
        if ($validator->fails()) $this->response->errorbadrequest(400008);
        $patients = Patient::where('name', $name);
        return $patients->get()->toArray();
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
