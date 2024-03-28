<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Wallet;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Wallet;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\WalletRepositoryContract;

class CheckBalanceWalletUseCase
{
    public function __construct(private WalletRepositoryContract $walletRepository)
    {
    }

    public function execute(int $customerId): Wallet
    {
        return $this->walletRepository->getBalanceByCustomerId($customerId);
    }
}
