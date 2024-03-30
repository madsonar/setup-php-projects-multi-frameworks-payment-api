<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;

interface TransactionRepositoryContract
{
    public function findById(int $id): Transaction|null;

    public function executeTransaction(Transaction $transaction): Transaction;

    public function revertTransaction(int $transactionId, string $transactionKey): Transaction;
}
