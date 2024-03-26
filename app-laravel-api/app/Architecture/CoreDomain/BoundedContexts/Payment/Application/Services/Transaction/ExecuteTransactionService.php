<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction\ExecuteTransactionUseCase;

class ExecuteTransactionService
{
    private $executeTransactionUseCase;

    public function __construct(ExecuteTransactionUseCase $executeTransactionUseCase)
    {
        $this->executeTransactionUseCase = $executeTransactionUseCase;
    }

    public function execute(Transaction $transaction): Transaction
    {
        return $this->executeTransactionUseCase->execute($transaction);
    }
}
