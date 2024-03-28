<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions\TransactionNotAuthorized;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalPaymentAuthorizerService;
use App\Architecture\Shared\Domain\Helpers\UuidHelper;

class RevertTransactionUseCase
{
    public function __construct(private TransactionRepositoryContract $transactionRepository, private ExternalPaymentAuthorizerService $paymentAuthorizer)
    {
    }

    public function revert(int $originalTransactionId): Transaction
    {
        $transactionKey = UuidHelper::generateUuid();
        if (! $this->paymentAuthorizer->authorizeTransaction($transactionKey)) {
            throw new TransactionNotAuthorized();
        }

        return $this->transactionRepository->revertTransaction($originalTransactionId, $transactionKey);
    }
}
