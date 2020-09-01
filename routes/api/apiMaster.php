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
    Route::put('propositions/{annonce_id}/{user_id}', 'Api\PropositionController@update');
    Route::get('propositions/accept/{id}', 'Api\PropositionController@accept');

    // Véhicule
    Route::get('vehicules/libre', 'Api\VehiculeController@libre');

    // Users
    Route::get('users/chauffeurs/libre', 'Api\UserController@chauffeurLibre');

    // Annonces
    Route::get('annonces/news', 'Api\AnnonceController@all_news');


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
});
