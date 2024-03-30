<?php

// phpcs:ignoreFile

declare(strict_types=1);

namespace App\Architecture\Shared\Domain\Contracts\Exception;

use Exception;

abstract class BaseException extends Exception implements ExceptionContract
{
    protected int $statusCode = 400;
    protected string $msg     = 'An error occurred';

    public function __construct(string|null $message = null, int|null $statusCode = null, protected array $data = [])
    {
        parent::__construct($message ?: $this->msg);

        if (! $statusCode) {
            return;
        }

        $this->statusCode = $statusCode;
    }

    public function response(): mixed
    {
        return response()->json([
            'data' => $this->data,
            'message' => $this->getMessage(),
        ], $this->statusCode);
    }
}
