<?php

namespace LaravelFlare\Flare\Traits\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

trait AuthenticatesAndResetsPasswords
{
    use AuthenticatesUsers, ResetsPasswords {
        AuthenticatesUsers::redirectPath insteadof ResetsPasswords;
    }
}
