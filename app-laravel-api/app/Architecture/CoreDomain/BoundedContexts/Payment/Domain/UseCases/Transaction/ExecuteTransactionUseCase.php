<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\CustomerType;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions\ShopkeeperCannotSend;

class ExecuteTransactionUseCase
{
    private TransactionRepositoryContract $transactionRepository;
    private CustomerRepositoryContract $customerRepository;

    public function __construct(
        TransactionRepositoryContract $transactionRepository,
        CustomerRepositoryContract $customerRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->customerRepository = $customerRepository;
    }

    public function execute(Transaction $transaction): Transaction
    {
        $payer = $this->customerRepository->findById($transaction->payerId);
        if ($payer->user_type === CustomerType::SHOPKEEPER) {
            throw new ShopkeeperCannotSend();
        }

        return $this->transactionRepository->executeTransaction($transaction);
    }
}
