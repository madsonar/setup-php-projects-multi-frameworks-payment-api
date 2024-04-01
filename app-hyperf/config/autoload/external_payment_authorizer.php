<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    'service_authorizer' => [
        'base_url' => env('API_EXTERNAL_PAYMENT_AUTHORIZER_BASE_URL', 'http://host.docker.internal:9011'),
    ],
];
