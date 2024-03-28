<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Application\Contracts\Request;

interface RequestContract
{
    public function validate(): void;
}
