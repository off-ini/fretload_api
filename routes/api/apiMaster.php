<?php
// User api

Route::group(['middleware' => 'jwt', 'prefix' => $v1Prefix], function () {
    // Type Véhicule
    Route::get('tvehicules/selected', 'Api\TypeVehiculeController@selected');

    // Type Marchandise
    Route::get('tmarchandises/selected', 'Api\TypeMarchandiseController@selected');

    // Adresse
    Route::get('adresses/selected', 'Api\AdresseController@selected');

    // Destinataire
    Route::get('destinataires/selected', 'Api\DestinataireController@selected');

    // Marchandise
    Route::get('marchandises/selected', 'Api\MarchandiseController@selected');

    // Proposition
    Route::get('propositions/accept/{id}', 'Api\PropositionController@accept');
    Route::get('propositions/annoncebyuser/{annonce_id}/{user_id}', 'Api\PropositionController@showByAnnonceAndUser');
    Route::put('propositions/{annonce_id}/{user_id}', 'Api\PropositionController@update');

    // Véhicule
    Route::get('vehicules/libre', 'Api\VehiculeController@libre');

    // Users
    Route::get('users/chauffeurs/libre', 'Api\UserController@chauffeurLibre');

    // Annonces
    Route::get('annonces/news', 'Api\AnnonceController@all_news');

    // Missions
    Route::get('missions/statistics', 'Api\MissionController@allCount');
    Route::post('missions/up/encours/{id}', 'Api\MissionController@upEnCours');
    Route::post('missions/up/livrer/{id}', 'Api\MissionController@upLivrer');
    Route::post('missions/up/payer/{id}', 'Api\MissionController@upPayer');
    Route::post('missions/paiding/{user_id}/{mission_id}', 'Api\MissionController@paiding');


    // CRUD Base
    Route::apiResource('users', 'Api\UserController');
    Route::apiResource('destinataires', 'Api\DestinataireController');
    Route::apiResource('adresses', 'Api\AdresseController');
    Route::apiResource('tvehicules', 'Api\TypeVehiculeController');
    Route::apiResource('tmarchandises', 'Api\TypeMarchandiseController');
    Route::apiResource('mpayements', 'Api\ModePayementController');
    Route::apiResource('marchandises', 'Api\MarchandiseController');
    Route::apiResource('vehicules', 'Api\VehiculeController');
    Route::apiResource('annonces', 'Api\AnnonceController');
    Route::apiResource('propositions', 'Api\PropositionController');
    Route::apiResource('missions', 'Api\MissionController');
    Route::apiResource('notifications', 'Api\NotificationController');
});
