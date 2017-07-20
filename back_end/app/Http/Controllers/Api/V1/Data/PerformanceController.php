<?php

namespace App\Http\Controllers\Api\V1\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use Validator;
use Dingo\Api\Routing\Helpers;
use DB;

class PerformanceController extends Controller
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
        // get all year's patient
        if ($name === 'year') {
            return [
                $this->deal_year(DB::select('SELECT state, created_at
                                FROM patients
                                WHERE date_format(created_at, "%Y") = date_format(now(), "%Y")')),
                $this->deal_year(DB::select('SELECT state, created_at
                                FROM patients
                                WHERE date_format(created_at, "%Y") = date_format(now(), "%Y")-1')),
                $this->deal_year(DB::select('SELECT state, created_at
                                FROM patients
                                WHERE date_format(created_at, "%Y") = date_format(now(), "%Y")-2'))
            ];
        } elseif ($name === 'month') {
            // get current year every month's patient
            return DB::select('SELECT state, created_at
                                FROM patients
                                WHERE date_format(created_at, "%Y %m") = date_format(now(), "%Y %m")');
        }
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

    private function deal_year($year_patients)
    {
        $item['name'] = date('Y', strtotime($year_patients[0]->created_at));
        $item['advisory_len'] = count($year_patients);
        $item['arrive_len'] = 0;
        $item['lose_len'] = 0;
        foreach ($year_patients as $patient) {
            if ($patient->state === 2) {
                $item['arrive_len']++;
            } else {
                $item['lose_len']++;
            }
        }
        return $item;
    }
}
