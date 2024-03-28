<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities;

class Wallet
{
    public function __construct(
        public int|null $id,
        public int $customerId,
        public string $accountNumber,
        public float $currentBalance,
    ) {
    }
}
