<?php

// register the 'admin' middleware
Route::middleware('admin', \App\Http\Middleware\Admin::class);
Route::group(['namespace' => '\Backpack\Base\app\Http\Controllers'], function ($router) {
    Route::group(
        [
            'middleware' => 'web',
            'prefix'     => config('backpack.base.route_prefix'),
        ],
        function () {
            // if not otherwise configured, setup the auth routes
            if (config('backpack.base.setup_auth_routes')) {
                Route::auth();
                Route::get('logout', 'Auth\LoginController@logout');
            }

            // if not otherwise configured, setup the dashboard routes
            if (config('backpack.base.setup_dashboard_routes')) {
                Route::get('dashboard', 'AdminController@dashboard');
            }
        });
});