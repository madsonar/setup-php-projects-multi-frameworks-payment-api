<?php

namespace App\Architecture\Shared\Application\Contracts\Request;

interface RequestContract
{
    public function validate(): void;
}
