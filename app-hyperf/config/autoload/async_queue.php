<?php

declare(strict_types=1);

use Hyperf\AsyncQueue\Driver\RedisDriver;

return [
    'default' => [
        'driver' => RedisDriver::class,
        'redis' => ['pool' => 'default'],
        'channel' => 'queue',
        'timeout' => 2,
        'retry_seconds' => 5,
        'handle_timeout' => 10,
        'processes' => 10,
        'concurrent' => ['limit' => 10],
    ],
];
