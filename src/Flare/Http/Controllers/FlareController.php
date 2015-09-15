<?php

namespace JacobBaileyLtd\Flare\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class FlareController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('flareauthenticate');
        $this->middleware('checkpermissions');
    }
}
