<?php

return [
    'users'   =>  [
        'base_uri'  =>  env('USERS_SERVICE_BASE_URL'),
        'secret'  =>  env('USERS_SERVICE_SECRET'),
    ],

    'courses'   =>  [
        'base_uri'  =>  env('COURSES_SERVICE_BASE_URL'),
        'secret'  =>  env('COURSES_SERVICE_SECRET'),
    ],
];