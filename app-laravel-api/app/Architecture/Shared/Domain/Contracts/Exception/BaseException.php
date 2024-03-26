<?php

namespace App\Architecture\Shared\Domain\Contracts\Exception;

use App\Architecture\Shared\Domain\Contracts\Exception\ExceptionContract;
use Exception;

abstract class BaseException extends Exception implements ExceptionContract
{
    protected $data = [];
    protected $statusCode = 400;
    protected $msg = 'An error occurred';

    public function __construct(string $message = null, int $statusCode = null, array $data = [])
    {
        parent::__construct($message ?: $this->msg);
        if ($statusCode) {
            $this->statusCode = $statusCode;
        }
        $this->data = $data;
    }

    public function response()
    {
        return response()->json([
            'data' => $this->data,
            'message' => $this->getMessage(),
        ], $this->statusCode);
    }
}
