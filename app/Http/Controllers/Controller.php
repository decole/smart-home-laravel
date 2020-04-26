<?php

namespace App\Http\Controllers;


use App\DeviceLocation;
use App\DeviceType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function typesList()
    {
        return DeviceType::all()->pluck('name', 'id');
    }

    public static function locationsList()
    {
        return DeviceLocation::all()->pluck('name', 'id');
    }
}
