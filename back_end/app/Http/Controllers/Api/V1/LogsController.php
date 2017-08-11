<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth, JWTException;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('allow_setting_module')) $this->response->errorForbidden(403033);
        if (!JWTAuth::parseToken()->authenticate()->roles[0]->hasPermission('setting/log')) $this->response->errorForbidden(403034);
        
        return Log::paginate(20);
    }
}
