<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Wallet as DomainWallet;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer as DomainCustomer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models\Customer as EloquentCustomer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models\Wallet as EloquentWallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerRepository implements CustomerRepositoryContract {
    public function saveWithWallet(DomainCustomer $domainCustomer): DomainCustomer {
        return DB::transaction(function () use ($domainCustomer) {
            $modelCustomer = new EloquentCustomer([
                'first_name' => $domainCustomer->first_name,
                'last_name'  => $domainCustomer->last_name,
                'document'   => $domainCustomer->document,
                'email'      => $domainCustomer->email,
                'password'   => bcrypt($domainCustomer->password),
                'user_type'  => $domainCustomer->user_type->value,
            ]);
            $modelCustomer->save();

            $walletModel = new EloquentWallet([
                'customer_id'    => $modelCustomer->id,
                'account_number' => $this->generateAccountNumber(),
                'current_balance' => 0.00,
            ]);
            $walletModel->save();

            $domainCustomer->id = $modelCustomer->id;
            $domainCustomer->wallet = new DomainWallet(
                id: $walletModel->id,
                customerId: $modelCustomer->id,
                accountNumber: $walletModel->account_number,
                currentBalance: $walletModel->current_balance
            );

            return $domainCustomer;
        });
    }

    private function generateAccountNumber() {
        return Str::uuid()->toString();
    }
}
