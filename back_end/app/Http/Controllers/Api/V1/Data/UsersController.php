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
        return User::where('id', 6)->with(['patient'=>function($query){
            $query->select('id', 'name', 'state', 'created_at', 'arrive_date');
            $query->with(['channel'=>function($c_query){
                return $c_query->where('id', 3);
            }]);
            return $query->where('state', 2);
        }])->get();
//        $parameters = Input::all();
//        $users = User::all();
//        $res = [];
//        $date_type = $parameters['date_type'] === 'created' ? 'created_at' : 'arrive_date';
//        if ($parameters['statistical_type'] === 'day' &&
//            date_diff(date_create($parameters['start_date']), date_create($parameters['end_date']))->m >= 1) {
//            // 按日计算, 范围超过一个月就按一个月算, 根据end_date修改start_date
//            $parameters['start_date'] = date('Y-m-d', strtotime($parameters['end_date'] . " -1 Month"));
//        }
//        if ($parameters['statistical_type'] === 'year') {
//            $start_date_year = date('Y', strtotime($parameters['start_date']));
//            $end_date_year = (int)date('Y', strtotime($parameters['end_date']));
//            for ($year = $end_date_year; $year >= $start_date_year; --$year) {
//                $item['date'] = $year;
//                $item['data'] = [];
//                foreach ($users as $user) {
//                    array_push($item['data'], $user);
//                }
//                array_push($res, $item);
//            }
//        }
//        return $res;



//        $patients = Patient::whereBetween($date_type, [$parameters['start_date'], $parameters['end_date']])->get();
//        if (key_exists('channel', $parameters)) {
//            $arr = [];
//            foreach ($patients as $patient) {
//                $patient->channel;
//                if ($patient->channel[0]->id === (int)$parameters['channel']) {
//                    array_push($arr, $patient);
//                }
//            }
//            $patients = $arr;
//        }
//        if (key_exists('state', $parameters)) {
//            $arr = [];
//            foreach ($patients as $patient) {
//                if ($patient->state === (int)$parameters['state']) {
//                    array_push($arr, $patient);
//                }
//            }
//            $patients = $arr;
//        }
//        if ($parameters['statistical_type'] === 'year') {
//            $state_date_year = date('Y', strtotime($parameters['start_date']));
//            $end_date_year = (int)date('Y', strtotime($parameters['end_date']));
//            for ($year=$end_date_year; $year>=$state_date_year; --$year) {
//                foreach ()
//            }
//        }
//        return $patients;
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
