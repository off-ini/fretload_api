<?php

use Illuminate\Http\Request;

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

$v1Prefix = 'v1/';

include base_path('routes/api/apiPublic.php');
include base_path('routes/api/apiUser.php');


Route::fallback(function(){
    return response()->json(['error' => 'Route Not Found'], 404);
});
