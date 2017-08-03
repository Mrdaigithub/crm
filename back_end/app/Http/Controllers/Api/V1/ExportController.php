<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Support\Facades\Input;
use Validator;
use Dingo\Api\Routing\Helpers;
use App\Models\Patient;
use App\Models\Management\Channel;
use App\Models\Management\Doctor;
use App\Models\Management\Disease;
use App\Models\Management\Advisory;
use App\Models\User;

class ExportController extends Controller
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
        $patients = new Patient();

        if (key_exists('state', $parameters) && Validator::make($parameters, ['state' => ['regex:/^(0|1|2|3)$/']])->fails()) $this->response->errorBadRequest(400041);
        if (key_exists('name', $parameters) && Validator::make($parameters, ['end_date' => 'string'])->fails()) $this->response->errorBadRequest(400036);
        if (key_exists('tel', $parameters) && Validator::make($parameters, ['tel' => ['regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/']])->fails()) $this->response->errorBadRequest(400039);
        if (key_exists('date_type', $parameters) && Validator::make($parameters, ['date_type' => ['regex:/^(created_at|arrive_date)$/']])->fails()) $this->response->errorBadRequest(400070);
        if (key_exists('start_date', $parameters) && Validator::make($parameters, ['start_date' => 'date'])->fails()) $this->response->errorBadRequest(400072);
        if (key_exists('end_date', $parameters) && Validator::make($parameters, ['end_date' => 'date'])->fails()) $this->response->errorBadRequest(400074);

        if (key_exists('user_id', $parameters)) {
            $patients = $patients->whereHas('user', function ($query) use ($parameters) {
                $query->where('id', $parameters['user_id']);
            });
        }
        if (key_exists('channel_id', $parameters)) {
            $patients = $patients->whereHas('channel', function ($query) use ($parameters) {
                $query->where('id', $parameters['channel_id']);
            });
        }
        if (key_exists('advisory_id', $parameters)) {
            $patients = $patients->whereHas('advisory', function ($query) use ($parameters) {
                $query->where('id', $parameters['advisory_id']);
            });
        }
        if (key_exists('doctor_id', $parameters)) {
            $patients = $patients->whereHas('doctor', function ($query) use ($parameters) {
                $query->where('id', $parameters['doctor_id']);
            });
        }
        if (key_exists('disease_id', $parameters)) {
            $patients = $patients->whereHas('disease', function ($query) use ($parameters) {
                $query->where('id', $parameters['disease_id']);
            });
        }
        if (key_exists('state', $parameters)) {
            $patients = $patients->where('state', $parameters['state']);
        }
        if (key_exists('name', $parameters)) {
            $patients = $patients->where('name', $parameters['name']);
        }
        if (key_exists('tel', $parameters)) {
            $patients = $patients->where('tel', $parameters['tel']);
        }
        if (!key_exists('date_type', $parameters)) {
            $parameters['date_type'] = 'created_at';
        }
        if (key_exists('start_date', $parameters) && key_exists('end_date', $parameters)) {
            $patients = $patients->whereBetween($parameters['date_type'], [$parameters['start_date'], $parameters['end_date']]);
        }
        $patients = $patients->get();
        foreach ($patients as $patient) {
            $patient->channel;
            $patient->advisory;
            $patient->doctor;
            $patient->disease;
        }
        $patients = array_map(function ($patient) {
            $patient['channel'] = $patient['channel'][0]['name'];
            $patient['advisory'] = $patient['advisory'][0]['name'];
            $patient['doctor'] = $patient['doctor'][0]['name'];
            $patient['disease'] = $patient['disease'][0]['name'];
            return $patient;
        }, $patients->toArray());
        $excel_data = $this->create_excel_data($patients);
        $this->create_excel_file('patient data', 'sheet1', $excel_data);
    }

    /**
     * create excel data
     *
     * @param $data
     * @return array
     */
    private function create_excel_data($data)
    {
        if (!count($data)) return [];
        $excel_data = [];
        array_push($excel_data, array_keys($data[0]));
        foreach ($data as $item) {
            array_push($excel_data, array_map(function ($i) {
                return $i;
            }, $item));
        }
        return $excel_data;
    }

    /**
     * create excel file
     *
     * @param string $file_name
     * @param string $sheet_name
     * @param $excel_data
     */
    private function create_excel_file($file_name = 'excel', $sheet_name = 'sheet', $excel_data)
    {
        Excel::create($file_name, function ($excel) use ($excel_data, $sheet_name) {
            $excel->sheet($sheet_name, function ($sheet) use ($excel_data) {
                $sheet->rows($excel_data);
            });
        })->export('xlsx');
    }
}
