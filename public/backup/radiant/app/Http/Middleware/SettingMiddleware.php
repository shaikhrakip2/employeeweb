<?php

namespace App\Http\Middleware;

use App\Models\GeneralSetting; 
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;


class SettingMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $data = array();
        $app_data = GeneralSetting::all();

        foreach ($app_data as $row) {
            $data[$row['setting_name']] = $row['filed_value'];
        }

        View::share('site_settings', $data); 

        return $next($request);
    }
}
