<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*', 'http://0.0.0.0:8080', 'https://0.0.0.0:8080/', 'http://192.168.1.222:8080', 'https://192.168.1.222:8080'],

    'allowed_origins_patterns' => ['/https?:\/\/0.0.0.0:8080\/?\z/', '/https?:\/\/192.168.1.222:8080\/?\z/'],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
