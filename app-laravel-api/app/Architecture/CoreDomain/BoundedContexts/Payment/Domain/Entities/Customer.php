<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities;

class Customer
{
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $document,
        public string $email,
        public string $password,
        public string $user_type,
    ) {}
}
