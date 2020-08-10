<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;

Route::get('/', function () {
    return response()->json(['message' => 'FretLoad API v1'], 200);
});

Route::get('/{path}', function () {
    return response()->json(['message' => 'FretLoad API v1'], 200);
})->where('path', '.*');
