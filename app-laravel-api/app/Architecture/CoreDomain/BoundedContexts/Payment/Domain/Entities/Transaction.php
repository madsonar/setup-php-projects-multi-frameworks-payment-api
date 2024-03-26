<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\TransactionStatus;

class Transaction
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $payerId,
        public readonly int $payeeId,
        public readonly float $value,
        public TransactionStatus $status,
        public ?string $transactionKey,
        public readonly ?int $revertedTransactionId = null
    ) {}

    public function setTransactionKey(string $key): void
    {
        $this->transactionKey = $key;
    }
}
