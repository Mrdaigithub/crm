<?php

namespace App\Http\Controllers\Api\V1\Data;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Management\Channel;
use Illuminate\Support\Facades\Input;
use Validator;
use Dingo\Api\Routing\Helpers;

class DiseasesController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'index';
    }
}
