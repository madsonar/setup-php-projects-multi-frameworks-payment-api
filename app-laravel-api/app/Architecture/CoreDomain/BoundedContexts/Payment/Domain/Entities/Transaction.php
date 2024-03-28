<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\TransactionStatus;

class Transaction
{
    public function __construct(
        public readonly int|null $id,
        public readonly int $payerId,
        public readonly int $payeeId,
        public readonly float $value,
        public TransactionStatus $status,
        public string|null $transactionKey,
        public readonly int|null $revertedTransactionId = null,
    ) {
    }

    public function setTransactionKey(string $key): void
    {
        $this->transactionKey = $key;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
