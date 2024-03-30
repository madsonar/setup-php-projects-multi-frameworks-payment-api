<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction as DomainTransaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\TransactionStatus;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions\InsufficientFunds;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models\Transaction as EloquentTransaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryContract
{
    public function findById(int $id): DomainTransaction|null
    {
        $transaction = EloquentTransaction::find($id);

        return $transaction ? $this->toDomainEntity($transaction) : null;
    }

    public function executeTransaction(DomainTransaction $domainTransaction): DomainTransaction
    {
        return DB::transaction(function () use ($domainTransaction) {
            $payerWallet = Wallet::where('customer_id', $domainTransaction->payerId)->lockForUpdate()->firstOrFail();
            $payeeWallet = Wallet::where('customer_id', $domainTransaction->payeeId)->lockForUpdate()->firstOrFail();

            if ($payerWallet->current_balance < $domainTransaction->value) {
                throw new InsufficientFunds();
            }

            $payerWallet->decrement('current_balance', $domainTransaction->value);
            $payeeWallet->increment('current_balance', $domainTransaction->value);

            $eloquentTransaction = EloquentTransaction::create([
                'payer_id' => $domainTransaction->payerId,
                'payee_id' => $domainTransaction->payeeId,
                'value' => $domainTransaction->value,
                'status' => TransactionStatus::COMPLETED->value,
                'transaction_key' => $domainTransaction->transactionKey,
            ]);

            return $this->toDomainEntity($eloquentTransaction);
        });
    }

    public function revertTransaction(int $originalTransactionId, string $transactionKey): DomainTransaction
    {
        return DB::transaction(function () use ($originalTransactionId, $transactionKey) {
            $originalTransaction = EloquentTransaction::findOrFail($originalTransactionId);

            if ($originalTransaction->status === TransactionStatus::REVERTED->value) {
                throw new Exception('This transaction has already been reverted.');
            }

            $revertedTransaction = new EloquentTransaction([
                'payer_id' => $originalTransaction->payee_id,
                'payee_id' => $originalTransaction->payer_id,
                'value' => $originalTransaction->value,
                'status' => TransactionStatus::REVERTED->value,
                'transaction_key' => $transactionKey,
                'reverted_transaction_id' => $originalTransaction->id,
            ]);

            $payerWallet = Wallet::where('customer_id', $revertedTransaction->payer_id)->lockForUpdate()->firstOrFail();
            $payeeWallet = Wallet::where('customer_id', $revertedTransaction->payee_id)->lockForUpdate()->firstOrFail();

            $payerWallet->decrement('current_balance', $revertedTransaction->value);
            $payeeWallet->increment('current_balance', $revertedTransaction->value);

            $revertedTransaction->save();

            $originalTransaction->update(['status' => TransactionStatus::REVERTED->value]);

            return $this->toDomainEntity($revertedTransaction);
        });
    }

    private function toDomainEntity(EloquentTransaction $eloquentTransaction): DomainTransaction
    {
        return new DomainTransaction(
            id: $eloquentTransaction->id,
            payerId: (int) $eloquentTransaction->payer_id,
            payeeId: (int) $eloquentTransaction->payee_id,
            value: (float) $eloquentTransaction->value,
            status: TransactionStatus::from($eloquentTransaction->status->value),
            transactionKey: $eloquentTransaction->transaction_key,
            revertedTransactionId: $eloquentTransaction->reverted_transaction_id,
        );
    }
}
