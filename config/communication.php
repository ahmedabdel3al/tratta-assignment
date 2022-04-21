<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Communication Provider
    |--------------------------------------------------------------------------
    |
    | This option define the default communication providers
    |
    */

    'default' => env('COMMUNICATION_PROVIDER', 'twilio'),
    /*
    |--------------------------------------------------------------------------
    |  COMMUNICATION Providers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the Communication providers for your application.
    | use like twilio ,Unifonic , ....etc
    |
    |
    */
    'providers' => [

        'twilio' => [
            'api_url' => env('COMMUNICATION_API_URL' ,''),
            'secret_token'=> env('COMMUNICATION_API_TOKEN' ,'')
        ],

    ],

];
