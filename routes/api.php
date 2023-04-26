<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function() {
    return response()->json([
        'tile'=>"Biblioteca",
        'year'=>"2022",
        'kind'=>"web",
        'time'=>"Six months",
        'description'=>"A very unique book catalogue online made for smart and lonely kids",
    
    ]);
}





);

