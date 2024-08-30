<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FICHIER DE CONFIGURATION DES VARIABLES D'ENVIRONNMENT
    |--------------------------------------------------------------------------
    |
    | Chaque fois qu'une variable est modifiée dans ce fichier, il faudra
    | faire à nouveau php artisan config:cache pour rendre la modification disponible.
    |
    */
    'APP_URL'                          => env('APP_URL', 'localhost/immo_back/public'),
    'FOLDER'                           => env('FOLDER', ''),
    'TWILIO_SID'                       => env('TWILIO_SID', ''),
    'TWILIO_AUTH_TOKEN'                => env('TWILIO_AUTH_TOKEN', ''),
    'TWILIO_PHONE_NUMBER'              => env('TWILIO_PHONE_NUMBER', ''),

];
