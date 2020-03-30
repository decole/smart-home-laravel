<?php


namespace App\Services;


class DataService
{
    public static function getCheckboxValue($name, \Illuminate\Http\Request $request)
    {
        return ($request->get($name) == 'state') ? true : false;
    }

    public static function getTextNotify($string, $substring)
    {
        return str_replace('{value}', $substring, $string );
    }

}
