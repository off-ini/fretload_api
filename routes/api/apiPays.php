<?php
// Pays api

Route::group(['middleware' => 'api', 'prefix' => $v1Prefix], function () {
    Route::apiResource('pays', 'Api\PaysController');
});
