<?php

namespace App\Architecture\Shared\Infrastructure\Adapters\Exception;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use App\Architecture\Shared\Infrastructure\Contracts\Response\BaseResponse;

class ErrorResponse extends BaseResponse
{
    public function __construct(string $message, int $statusCode, array $data = [])
    {
        parent::__construct($data, $statusCode, $message);
    }

    public function response(PsrResponseInterface $response): PsrResponseInterface
    {
        return parent::response($response);
    }
}
