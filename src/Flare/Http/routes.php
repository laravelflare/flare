<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/admin', function () {
});
*/

// We should allow 'admin' to be determined as a config variable
Route::group(['prefix' => 'admin'], function () {
    // Admin routes should really have auth filter, or actually, our own permissions filter.
    (new \JacobBaileyLtd\Flare\Admin\ModelAdminCollection())->registerRoutes();

    // Admin Default Routes, make sure not to ovverride!
    Route::controller('/', '\JacobBaileyLtd\Flare\Http\Controllers\AdminController');
});

//dd(\Route::getRoutes());
