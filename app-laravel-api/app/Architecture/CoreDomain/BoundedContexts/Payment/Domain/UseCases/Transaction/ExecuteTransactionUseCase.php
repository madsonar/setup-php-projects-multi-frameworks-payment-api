<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions\ShopkeeperCannotSend;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions\TransactionNotAuthorized;
use App\Architecture\Shared\Domain\Helpers\UuidHelper;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalPaymentAuthorizerService;

class ExecuteTransactionUseCase
{
    private TransactionRepositoryContract $transactionRepository;
    private CustomerRepositoryContract $customerRepository;
    private ExternalPaymentAuthorizerService $paymentAuthorizer;

    public function __construct(
        TransactionRepositoryContract $transactionRepository,
        CustomerRepositoryContract $customerRepository,
        ExternalPaymentAuthorizerService $paymentAuthorizer
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->customerRepository = $customerRepository;
        $this->paymentAuthorizer = $paymentAuthorizer;
    }

    public function execute(Transaction $transaction): Transaction
    {
        $this->validatePayer($transaction->payerId);
        
        $transactionKey = $this->authorizeTransaction();

        $transaction->setTransactionKey($transactionKey);
        
        return $this->transactionRepository->executeTransaction($transaction);
    }

    private function validatePayer(int $payerId): void
    {
        $payer = $this->customerRepository->findById($payerId);
        
        if ($payer->isShopkeeper()) {
            throw new ShopkeeperCannotSend();
        }
    }

    private function authorizeTransaction(): string
    {
        $transactionKey = UuidHelper::generateUuid();
        
        if (!$this->paymentAuthorizer->authorizeTransaction($transactionKey)) {
            throw new TransactionNotAuthorized();
        }

        return $transactionKey;
    }
}
