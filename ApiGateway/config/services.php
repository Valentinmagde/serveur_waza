<?php

return [
    'passport'   =>  [
        'login_endpoint'  =>  env('PASSPORT_LOGIN_ENDPOINT'),
        'client_id'       =>  env('PASSPORT_CLIENT_ID'),
        'client_secret'   =>  env('PASSPORT_CLIENT_SECRET'),
    ],

    'gateway' =>  [
        'base_uri'  =>  env('APP_URL'),
    ],

    'users'   =>  [
        'base_uri'  =>  env('USERS_SERVICE_BASE_URL'),
        'secret'  =>  env('USERS_SERVICE_SECRET'),
    ],

    'courses'   =>  [
        'base_uri'  =>  env('COURSES_SERVICE_BASE_URL'),
        'secret'  =>  env('COURSES_SERVICE_SECRET'),
    ],
];