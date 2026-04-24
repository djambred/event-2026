<?php

$allowedOrigins = array_filter(array_map('trim', explode(',', env(
    'CORS_ALLOWED_ORIGINS',
    'https://international-events2026.esaunggul.ac.id,https://event.test,http://event.test,https://event.test:9443,http://event.test:9443'
))));

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'livewire/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => $allowedOrigins,

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
