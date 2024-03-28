<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction\ExecuteTransactionUseCase;

class ExecuteTransactionService
{
    public function __construct(private ExecuteTransactionUseCase $executeTransactionUseCase)
    {
        $this->executeTransactionUseCase = $executeTransactionUseCase;
    }

    public function execute(Transaction $transaction): Transaction
    {
        return $this->executeTransactionUseCase->execute($transaction);
    }
}
