<?php

if (!function_exists('getActiveUser')) {
    function getActiveUser()
    {
        return \Session::get('user'. \Auth::user()->id);
    }
}

if (!function_exists('getActionName')) {
    function getActionName()
    {
        preg_match("/.+@(.+)/",
            \Route::getCurrentRoute()->getActionName(), $matches);
        if (!empty($matches[1])) {
            return $matches[1];
        }
    }
}
