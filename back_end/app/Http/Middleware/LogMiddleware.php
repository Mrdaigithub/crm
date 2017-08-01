<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth, JWTException;
use App\Models\Log;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $log = new Log();
        $log->method = $request->method();
        $log->ip = $request->ip();
        $log->path = $request->path();
        if ($request->path() === 'api/login') {
            $log->username = $request->only('username')['username'];
            $log->data = json_encode($request->all());
            $log->description = "$log->username login";
        } elseif ($request->path() === 'api/logout') {
            $log->username = JWTAuth::parseToken()->authenticate()->username;
            $log->data = json_encode([]);
            $log->description = "$log->username logout";
        }
        $log->save();
        return $next($request);
    }
}
