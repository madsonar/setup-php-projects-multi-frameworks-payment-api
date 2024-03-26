<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction\RevertTransactionUseCase;

class RevertTransactionService
{
    private $revertTransactionUseCase;

    public function __construct(RevertTransactionUseCase $revertTransactionUseCase)
    {
        $this->revertTransactionUseCase = $revertTransactionUseCase;
    }

    public function revert(int $id): Transaction
    {
        return $this->revertTransactionUseCase->revert($id);
    }
}

