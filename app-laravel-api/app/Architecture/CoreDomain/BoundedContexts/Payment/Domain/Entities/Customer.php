<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\CustomerType;

class Customer
{
    public function __construct(
        public ?int $id,
        public string $first_name,
        public string $last_name,
        public string $document,
        public string $email,
        public string $password,
        public CustomerType $user_type,
        public ?Wallet $wallet = null,
    ) {}
}
