<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Wallet;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\WalletRepositoryContract;

class CheckBalanceWalletService
{
    private WalletRepositoryContract $walletRepository;

    public function __construct(WalletRepositoryContract $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function checkBalance(int $customerId)
    {
        return $this->walletRepository->getBalanceByCustomerId($customerId);
    }
}
