<?php

namespace App\Http\Controllers\Api\V1;

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
        return Patient::paginate(5);
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
            'advisory_date' => 'required|date',
            'advisory_id' => 'required|numeric|exists:advisories,id',
            'channel_id' => 'required|numeric|exists:channels,id',
            'disease_id' => 'required|numeric|exists:diseases,id',
            'doctor_id' => 'required|numeric|exists:doctors,id'
        ]);
        if ($validator->fails()) $this->response->errorBadRequest();

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
        if (!$patient->save()) $this->response->errorInternal();
        $this->attach($patient['id'], $parameters['advisory_id']);
        return $patient;
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
        $validator = validator::make(
            [
                'id' => $id,
            ],
            [
                'id' => 'numeric|exists:patients',
            ]);
        if ($validator->fails()) $this->response->errorbadrequest();

        $patient = Patient::find($id);
        if (!$patient->delete()) $this->response->errorInternal();
        return;
    }

    private function attach($patient_id, $advisory_id)
    {
        $validator = validator::make(
            [
                'id' => $advisory_id,
            ],
            [
                'id' => 'required|numeric|exists:advisories',
            ]);
        if ($validator->fails()) $this->response->errorbadrequest();
        DB::insert('insert into patient_advisory (patient_id, advisory_id) VALUES (?, ?)', [$patient_id, $advisory_id]);
    }
}
