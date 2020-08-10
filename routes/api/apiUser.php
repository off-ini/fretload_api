<?php
// User api

Route::group(['middleware' => 'jwt', 'prefix' => $v1Prefix], function () {
    Route::apiResource('users', 'Api\UserController');
});
