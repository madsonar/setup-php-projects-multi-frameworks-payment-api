<?php

// phpcs:ignoreFile

declare(strict_types=1);

namespace App\Architecture\Shared\Domain\Contracts\Job;

interface JobContract
{
    public function dispatch(array $details): void;
}
