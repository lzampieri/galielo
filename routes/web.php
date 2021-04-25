<?php

use Illuminate\Support\Facades\Route;

// Routing is managed by React
Route::get('/{path?}', function () {
    return view('welcome');
})->where('path','.*');
