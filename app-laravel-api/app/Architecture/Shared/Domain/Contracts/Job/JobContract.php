<?php

namespace App\Architecture\Shared\Domain\Contracts\Job;

interface JobContract
{
    public function dispatch(array $details): void;
}
