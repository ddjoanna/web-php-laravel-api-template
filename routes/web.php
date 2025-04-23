<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/set-horizon-cookie', function () {
    return response('Cookie set')->cookie('horizon', 'horizon', 60);
});
