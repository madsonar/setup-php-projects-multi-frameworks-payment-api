<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;

interface TransactionRepositoryContract
{
    public function findById(int $id): ?Transaction;
    public function executeTransaction(Transaction $transaction): Transaction;
    public function revertTransaction(int $transactionId): Transaction;
}
