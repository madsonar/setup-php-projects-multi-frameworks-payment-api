<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\CustomerType;

class Customer
{
    public function __construct(
        public int|null $id,
        public string $first_name,
        public string $last_name,
        public string $document,
        public string $email,
        public string $password,
        public CustomerType $user_type,
        public Wallet|null $wallet = null,
    ) {
    }

    public function isShopkeeper(): bool
    {
        return $this->user_type === CustomerType::SHOPKEEPER;
    }

    public function getFullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
