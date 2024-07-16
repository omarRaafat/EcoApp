<?php

    return [
        'sso_url' => env('EPORTAL_SSO', 'https://e-farmer.tasksa.dev/'),
        'client_id' => env('EPORTAL_CLIENT_ID', ''),
        'client_secret' => env('EPORTAL_SECRET', ''),
        'client_callback' => env('EPORTAL_CALLBACK', ''),
        'mouzare_frontend_callback' => env('MOUZARE_FRONTEND_CALLBACK', ''),
        'sso_secret' => env('EPORTAL_SSO_SECRET_KEY', ''),
    ];

