<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Wallet;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Wallet;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\WalletRepositoryContract;

class CheckBalanceWalletService
{
    public function __construct(private WalletRepositoryContract $walletRepository)
    {
    }

    public function checkBalance(int $customerId): Wallet
    {
        return $this->walletRepository->getBalanceByCustomerId($customerId);
    }
}
