<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Response\Customer;

use App\Architecture\Shared\Application\Contracts\Response\ResponseInterface;

class CreateCustomerResponse implements ResponseInterface
{
    private array $data;
    private int $statusCode;
    private string $msg;

    public function __construct(array $data, int $statusCode = 200, string $msg = "")
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->msg = $msg;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getMessage(): string
    {
        return $this->msg;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function response()
    {
        return response()->json([
            'data' => $this->getData(),
            'message' => $this->getMessage(),
        ], $this->getStatusCode());
    }
}
