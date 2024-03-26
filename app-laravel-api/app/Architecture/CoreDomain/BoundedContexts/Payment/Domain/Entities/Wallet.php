<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities;

class Wallet
{
    public function __construct(
        public ?int $id,
        public int $customerId,
        public string $accountNumber,
        public float $currentBalance
    ) {}
}
