<?php

namespace App\Architecture\Shared\Application\Contracts\Response;

use App\Architecture\Shared\Application\Contracts\Response\ResponseContract;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponse implements ResponseContract
{
    protected array $data;
    protected int $statusCode;
    protected string $message;

    public function __construct(array $data = [], int $statusCode = Response::HTTP_OK, string $message = '')
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    public function response()
    {
        return response()->json([
            'data' => $this->data,
            'message' => $this->message ?: 'Operation successful',
        ], $this->statusCode);
    }
}
