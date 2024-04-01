<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer as DomainCustomer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Wallet as DomainWallet;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models\Customer as EloquentCustomer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models\Wallet as EloquentWallet;
use App\Architecture\Shared\Domain\Helpers\UuidHelper;
use Hyperf\DbConnection\Db;

use function password_hash;

use const PASSWORD_BCRYPT;

class CustomerRepository implements CustomerRepositoryContract
{
    public function saveWithWallet(DomainCustomer $domainCustomer): DomainCustomer
    {
        return Db::transaction(function () use ($domainCustomer) {
            $modelCustomer = new EloquentCustomer([
                'first_name' => $domainCustomer->first_name,
                'last_name'  => $domainCustomer->last_name,
                'document'   => $domainCustomer->document,
                'email'      => $domainCustomer->email,
                'password'   => password_hash($domainCustomer->password, PASSWORD_BCRYPT),
                'user_type'  => $domainCustomer->user_type->value,
            ]);
            $modelCustomer->save();

            $walletModel = new EloquentWallet([
                'customer_id'     => $modelCustomer->id,
                'account_number'  => $this->generateAccountNumber(),
                'current_balance' => 1000.00, // temporary registration promotion
            ]);
            $walletModel->save();

            $domainCustomer->id     = $modelCustomer->id;
            $domainCustomer->wallet = new DomainWallet(
                id: $walletModel->id,
                customerId: $modelCustomer->id,
                accountNumber: $walletModel->account_number,
                currentBalance: $walletModel->current_balance,
            );

            return $domainCustomer;
        });
    }

    private function generateAccountNumber(): string
    {
        return UuidHelper::generateUuid();
    }

    public function findById(int $id): DomainCustomer|null
    {
        $model = EloquentCustomer::find($id);
        if (! $model) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    private function toDomainEntity(EloquentCustomer $model): DomainCustomer
    {
        $wallet = null;
        if ($model->wallet) {
            $wallet = new DomainWallet(
                id: $model->wallet->id,
                customerId: $model->wallet->customer_id,
                accountNumber: $model->wallet->account_number,
                currentBalance: $model->wallet->current_balance,
            );
        }

        return new DomainCustomer(
            id: $model->id,
            first_name: $model->first_name,
            last_name: $model->last_name,
            document: $model->document,
            email: $model->email,
            password: $model->password,
            user_type: $model->user_type,
            wallet: $wallet,
        );
    }
}
