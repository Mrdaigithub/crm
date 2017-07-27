<?php

namespace App\Http\Controllers\Api\V1\Data;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Management\Channel;
use Illuminate\Support\Facades\Input;
use Validator;
use Dingo\Api\Routing\Helpers;

class ChannelsController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = Input::all();

        if (!key_exists('statistical_type', $parameters)) $parameters['statistical_type'] = 'month';
        if (Validator::make($parameters, ['statistical_type' => 'required'])->fails()) $this->response->errorBadRequest(400067);
        if (Validator::make($parameters, ['statistical_type' => ['regex:/^(year|month|day)$/']])->fails()) $this->response->errorBadRequest(400068);
        if (!key_exists('date_type', $parameters)) $parameters['date_type'] = 'created_at';
        if (Validator::make($parameters, ['date_type' => 'required'])->fails()) $this->response->errorBadRequest(400069);
        if (Validator::make($parameters, ['date_type' => ['regex:/^(created_at|arrive_date)$/']])->fails()) $this->response->errorBadRequest(400070);
        if (Validator::make($parameters, ['start_date' => 'required'])->fails()) $this->response->errorBadRequest(400071);
        if (Validator::make($parameters, ['start_date' => 'date'])->fails()) $this->response->errorBadRequest(400072);
        if (Validator::make($parameters, ['end_date' => 'required'])->fails()) $this->response->errorBadRequest(400073);
        if (Validator::make($parameters, ['end_date' => 'date'])->fails()) $this->response->errorBadRequest(400074);
        if (key_exists('state', $parameters) && Validator::make($parameters, ['state' => ['regex:/^(0|1|2|3)$/']])->fails()) $this->response->errorBadRequest(400041);

        $dates = $this->createDateRange($parameters['statistical_type'], $parameters['start_date'], $parameters['end_date']);
        $res = [];
        $res['data'] = $res['date'] = [];
        foreach ($dates as $date) {
            $channels = Channel::find(1)->with(['patient' => function ($query) use ($parameters, $date) {
                $query->select('id', 'name', 'state', 'created_at', 'arrive_date');
                if (key_exists('state', $parameters)) {
                    return $query->where('state', $parameters['state'])
                        ->whereBetween($parameters['date_type'], [$date[0], $date[1]]);
                } else {
                    return $query->whereBetween($parameters['date_type'], [$date[0], $date[1]]);
                }
            }])->get();
            foreach ($channels as $channel) {
                $item[$channel->name] = count($channel->patient);
            }
            array_push($res['data'], $item);
        }
        foreach ($dates as $date) {
            if ($parameters['statistical_type'] === 'year') array_push($res['date'], date('Y', strtotime($date[0])));
            elseif ($parameters['statistical_type'] === 'month') array_push($res['date'], date('Y-m', strtotime($date[0])));
            elseif ($parameters['statistical_type'] === 'day') array_push($res['date'], date('Y-m-d', strtotime($date[0])));
        }
        return $res;
    }

    /**
     * 创建日期范围
     *
     * @param $statistical_type
     * @param $_start_date
     * @param $_end_date
     * @return array
     */
    private function createDateRange($statistical_type = 'month', $_start_date, $_end_date)
    {
        $dates = [];
        if ($statistical_type === 'year') {
            $start_date = (int)date('Y', strtotime($_start_date));
            $end_date = (int)date('Y', strtotime($_end_date));
            for ($year = $start_date; $year <= $end_date; $year++) {
                if ($year === $start_date) {
                    array_push($dates, [$_start_date, $year . '-12-31']);
                    continue;
                }
                if ($year === $end_date) {
                    array_push($dates, [$year . '-01-01', $_end_date]);
                    continue;
                }
                array_push($dates, [$year . '-01-01', $year . '-12-31']);
            }
        } elseif ($statistical_type === 'month') {
            $_start_date = date('Y-m', strtotime($_start_date));
            $_end_date = date('Y-m', strtotime($_end_date));
            $month_diff = date_diff(date_create($_start_date), date_create($_end_date));
            $sum_month = $month_diff->y * 12 + $month_diff->m;
            for ($i = 0, $j = 1; $i <= $sum_month; $i++, $j++) {
                array_push($dates, [date('Y-m-d', strtotime("$_start_date+$i Month")), date('Y-m-d', strtotime("$_start_date+$j Month"))]);
            }
        } elseif ($statistical_type === 'day') {
            $start_date = date('Y-m-d', strtotime($_start_date));
            $end_date = date('Y-m-d', strtotime($_end_date));
            $date_diff = date_diff(date_create($_start_date), date_create($_end_date));
            if ($date_diff->m > 0) {
                $start_date = date("Y-m-d", strtotime("$end_date-1 Month"));
                $date_diff = date_diff(date_create($start_date), date_create($_end_date));
            }
            for ($i = 0, $j = 1; $i <= $date_diff->days; $i++, $j++) {
                array_push($dates, [date("Y-m-d", strtotime("$start_date+$i Day")), date("Y-m-d", strtotime("$start_date+$j Day"))]);
            }
        }
        return $dates;
    }
}
