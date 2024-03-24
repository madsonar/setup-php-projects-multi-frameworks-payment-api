<?php

namespace App\Architecture\Shared\Application\Contracts\Request;

interface RequestInterface
{
    public function validate(): void;
}
