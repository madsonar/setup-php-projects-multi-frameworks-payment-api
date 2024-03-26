<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;

class ExecuteTransactionUseCase
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryContract $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function execute(Transaction $transaction): Transaction
    {
        return $this->transactionRepository->executeTransaction($transaction);
    }
}
