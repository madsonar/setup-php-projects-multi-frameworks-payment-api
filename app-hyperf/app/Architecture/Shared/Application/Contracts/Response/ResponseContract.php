<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Application\Contracts\Response;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface ResponseContract
{
    public function response(PsrResponseInterface $response): PsrResponseInterface;
}
