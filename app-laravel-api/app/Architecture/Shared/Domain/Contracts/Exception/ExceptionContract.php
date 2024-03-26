<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Domain\Contracts\Exception;

interface ExceptionContract
{
    /*public function __construct(array $data, int $statusCode = 200, string $msg = "");

    public function getData(): array;

    public function getMessage(): string;

    public function getStatusCode(): int;
    */
    /**
     * @return mixed
     */
    public function response();
}
