<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Domain\Contracts\Exception;

interface ExceptionContract
{
    public function getStatusCode(): int;

    public function getResponseData(): array;
}
