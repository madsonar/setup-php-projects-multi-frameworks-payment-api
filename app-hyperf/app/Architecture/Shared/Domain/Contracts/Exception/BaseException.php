<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Domain\Contracts\Exception;

use Exception;

abstract class BaseException extends Exception implements ExceptionContract
{
    protected int $statusCode = 400;

    public function __construct(string $message = '', int|null $statusCode = null, protected array $data = [])
    {
        parent::__construct($message);

        if ($statusCode !== null) {
            $this->statusCode = $statusCode;
        }

        $this->data = $data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseData(): array
    {
        return [
            'message' => $this->getMessage(),
            'data' => $this->data,
        ];
    }
}
