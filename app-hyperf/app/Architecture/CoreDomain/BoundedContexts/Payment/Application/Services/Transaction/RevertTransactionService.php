<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction\RevertTransactionUseCase;

class RevertTransactionService
{
    public function __construct(private RevertTransactionUseCase $revertTransactionUseCase)
    {
        $this->revertTransactionUseCase = $revertTransactionUseCase;
    }

    public function revert(int $id): Transaction
    {
        return $this->revertTransactionUseCase->revert($id);
    }
}
