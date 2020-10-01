<?php
// User api

Route::group(['middleware' => 'jwt', 'prefix' => $v1Prefix], function () {
    Route::apiResource('users', 'Api\UserController');
});

Route::group(['middleware' => 'api', 'prefix' => $v1Prefix], function () {
    Route::post('register', 'Api\UserController@store');
});
