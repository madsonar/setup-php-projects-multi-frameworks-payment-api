<?php

declare(strict_types=1);

use App\Architecture\Shared\Infrastructure\Adapters\Exception\HyperfExceptionHandler;
use App\Exception\Handler\AppExceptionHandler;
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 *
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 */
return [
    'handler' => [
        'http' => [
            HyperfExceptionHandler::class,
            HttpExceptionHandler::class,
            AppExceptionHandler::class,
        ],
    ],
];
