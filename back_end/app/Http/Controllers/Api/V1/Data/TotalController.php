<?php

namespace App\Http\Controllers\Api\V1\Data;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Validator;
use Dingo\Api\Routing\Helpers;

class TotalController extends Controller
{
    use Helpers;

    /**
     * Display the data by year.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_by_year()
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('allow_data_module')) $this->response->errorForbidden(403005);
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('data/total')) $this->response->errorForbidden(403006);

        $current_year_date = date('Y', time());
        $current_year_patients = Patient::whereBetween('created_at', ["$current_year_date-01-01", "$current_year_date-12-31"])->get();
        $old_year_date = date('Y', time()) - 1;
        $old_year_patients = Patient::whereBetween('created_at', ["$old_year_date-01-01", "$old_year_date-12-31"])->get();
        $before_year_date = date('Y', time()) - 2;
        $before_year_patients = Patient::whereBetween('created_at', ["$before_year_date-01-01", "$before_year_date-12-31"])->get();

        return [
            $this->deal($current_year_patients, $current_year_date),
            $this->deal($old_year_patients, $old_year_date),
            $this->deal($before_year_patients, $before_year_date)
        ];
    }

    /**
     * Display the data by month.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_by_month()
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('allow_data_module')) $this->response->errorForbidden(403005);
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('data/total')) $this->response->errorForbidden(403006);

        $res = [];
        for ($i = 0; $i < 12; $i++) {
            $m = date('Y-m', strtotime("-$i Month"));
            $m_start = "$m-01";
            $m_end = "$m-31";
            $item = $this->deal(Patient::whereBetween('created_at', [$m_start, $m_end])->get(), $m);
            array_push($res, $item);
        }
        return $res;
    }

    private function deal($patients, $date)
    {
        $item['date'] = (string)$date;
        if ($patients === []) {
            $item['advisory'] = 0;
            $item['arrive'] = 0;
            $item['lose'] = 0;
        } else {
            $item['advisory'] = count($patients);
            $item['arrive'] = 0;
            $item['lose'] = 0;
            foreach ($patients as $patient) {
                if ($patient->state === 2) $item['arrive']++;
                if ($patient->state === 3) $item['lose']++;
            }
        }
        return $item;
    }
}
