<?php
// public api

Route::group(['middleware' => 'api', 'prefix' => $v1Prefix.'auth'], function () {

    //Login User
    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('me', 'Auth\AuthController@me');

});

Route::group(['middleware' => 'api', 'prefix' => $v1Prefix], function () {
    Route::post('register', 'Api\UserController@register');

    // CRUD Base
    Route::apiResource('pays', 'Api\PaysController');
    Route::apiResource('links', 'Api\LinkController');
    Route::apiResource('roles', 'Api\RoleController');
});


