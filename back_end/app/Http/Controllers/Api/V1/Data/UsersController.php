<?php

namespace App\Http\Controllers\Api\V1\Data;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use App\Models\Management\Channel;
use Illuminate\Support\Facades\Input;
use Validator;
use Dingo\Api\Routing\Helpers;

class UsersController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $ONE_MONTH_TIME = 30 * 24 * 60 * 60;
    }

    /**
     * argument:
     *  统计类型(statistical_type: year, month, day(范围超过一个月就按一个月算))
     *  时间类型(登记时间, 到诊时间: created, arrived) --- ok
     *  开始时间 --- ok
     *  截至时间 --- ok
     *  渠道来源(channels) --- ok
     *  客户状态(4个基本状态) --- ok
     *
     *  [
     *    "2015": {
     *      "root": 0,
     *      "user": 0
     *    },
     *    "2016": {
     *      "root": 10,
     *      "user": 150
     *    },
     *    "2016": {
     *      "root": 103,
     *      "user": 1050
     *    },
     *  ]
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = Input::all();
        $users = User::all();
        $dates = $this->createDateRange($parameters['statistical_type'], $parameters['start_date'], $parameters['end_date']);

        foreach ($users as $user) {
            $x = $user->with(['patient' => function ($query) use ($parameters) {
//                $query->select('id', 'name', 'state', 'created_at', 'arrive_date');
//                $query->with(['channel' => function ($c_query) use ($parameters) {
//                    return $c_query->where('id', $parameters['channel']);
//                }]);
                return $query->where('state', 2)
                    ->whereBetween($parameters['date_type'], ['2016-04-08', '2017-7-24']);
            }])->get();
            print_r(json_encode($x));
        }
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
                array_push($dates, [date('Y-m', strtotime("$_start_date+$i Month")), date('Y-m', strtotime("$_start_date+$j Month"))]);
            }
        } elseif ($statistical_type === 'day') {
            $start_date = date('Y-m-d', strtotime($_start_date));
            $end_date = date('Y-m-d', strtotime($_end_date));
            $date_diff = date_diff(date_create($_start_date), date_create($_end_date));
            if ($date_diff->m <= 0) {
                for ($i = 0, $j = 1; $i <= $date_diff->d; $i++, $j++) {
                    array_push($dates, [date("Y-m-d", strtotime("$start_date+$i Day")), date("Y-m-d", strtotime("$start_date+$j Day"))]);
                }
            }
        }
        return $dates;
    }
}
