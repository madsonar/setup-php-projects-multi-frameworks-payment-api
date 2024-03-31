<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Wallet as DomainWallet;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\WalletRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models\Wallet as EloquentWallet;

class WalletRepository implements WalletRepositoryContract
{
    public function getBalanceByCustomerId(int $customerId): ?DomainWallet
    {
        $wallet = EloquentWallet::query()->where('customer_id', $customerId)->first();

        if (!$wallet) {
            return null;
        }

        return new DomainWallet(
            id: $wallet->id,
            customerId: $wallet->customer_id,
            accountNumber: $wallet->account_number,
            currentBalance: $wallet->current_balance,
        );
    }
}
