<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use JWTAuth, JWTException;
use App\Models\Log;
use App\Models\Patient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Request $request
     * @return void
     */
    public function boot(Request $request)
    {
        Patient::created(function ($patient) use ($request) {
            $log = $this->initLogInfo($request);
            $log->description = "$log->username create patient $patient->name";
            $log->save();
        });
        Patient::updated(function ($patient) use ($request) {
            $log = $this->initLogInfo($request);
            $log->description = "$log->username updated patient $patient->name";
            $log->save();
        });
        Patient::deleted(function ($patient) use ($request) {
            $log = $this->initLogInfo($request);
            $log->description = "$log->username remove patient $patient->name";
            $log->save();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function initLogInfo($request)
    {
        $log = new Log();
        $log->username = JWTAuth::parseToken()->authenticate()->username;
        $log->method = $request->method();
        $log->ip = $request->ip();
        $log->path = $request->path();
        $log->data = json_encode([]);
        if ($log->method === 'GET') $log->data = json_encode($request->input());
        if ($log->method === 'POST' || $log->method === 'PATCH' || $log->method === 'PUT') $log->data = json_encode($request->all());
        return $log;
    }
}
