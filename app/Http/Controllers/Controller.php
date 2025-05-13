<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('yourLoginRouteName');
        }
    }
}
