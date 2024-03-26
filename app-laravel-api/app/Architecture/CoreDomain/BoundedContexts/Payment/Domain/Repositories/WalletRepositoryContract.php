<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Wallet;

interface WalletRepositoryContract
{
    public function getBalanceByCustomerId(int $customerId): ?Wallet;
}
