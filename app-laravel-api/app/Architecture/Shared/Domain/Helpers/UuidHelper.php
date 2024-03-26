<?php

namespace App\Architecture\Shared\Domain\Helpers;

use Illuminate\Support\Str;

class UuidHelper
{
    public static function generateUuid(): string
    {
        return (string) Str::uuid();
    }
}
