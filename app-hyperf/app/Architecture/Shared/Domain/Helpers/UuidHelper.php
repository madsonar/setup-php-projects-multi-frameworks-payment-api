<?php

// phpcs:ignoreFile

namespace App\Architecture\Shared\Domain\Helpers;

use Ramsey\Uuid\Uuid;

class UuidHelper
{
    public static function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
