<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Application\Contracts\Response;

interface ResponseContract
{
    public function response(): mixed;
}
