<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Wallet;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\WalletRepositoryContract;

class CheckBalanceWalletUseCase
{
    private $walletRepository;

    public function __construct(WalletRepositoryContract $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function execute(int $customerId)
    {
        return $this->walletRepository->getBalanceByCustomerId($customerId);
    }
}

