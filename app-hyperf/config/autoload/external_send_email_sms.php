<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    'service_send_email_sms' => [
        'base_url' => env('API_EXTERNAL_SEND_EMAIL_SMS_BASE_URL', 'http://host.docker.internal:9011'),
    ],
];
