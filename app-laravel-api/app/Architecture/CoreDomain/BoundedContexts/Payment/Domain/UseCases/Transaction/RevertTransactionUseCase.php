<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;

class RevertTransactionUseCase
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryContract $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function revert(int $id): Transaction
    {
        return $this->transactionRepository->revertTransaction($id);
    }
}


