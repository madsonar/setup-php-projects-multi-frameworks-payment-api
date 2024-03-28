<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Application\Contracts\Response;

use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponse implements ResponseContract
{
    public function __construct(protected array $data = [], protected int $statusCode = Response::HTTP_OK, protected string $message = '')
    {
    }

    public function response(): mixed
    {
        return response()->json([
            'data' => $this->data,
            'message' => $this->message ?: 'Operation successful',
        ], $this->statusCode);
    }
}
