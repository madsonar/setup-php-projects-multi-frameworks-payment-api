<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Transaction;

use App\Architecture\Shared\Application\Contracts\Response\BaseResponse;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;

class RevertTransactionResponse extends BaseResponse
{
    public function __construct(Transaction $transaction)
    {
        $data = [
            'transaction' => [
                'id' => $transaction->id,
                'payer_id' => $transaction->payerId,
                'payee_id' => $transaction->payeeId,
                'value' => $transaction->value,
                'status' => $transaction->status->value,
                'transaction_key' => $transaction->transactionKey,
                'reverted_transaction_id' => $transaction->revertedTransactionId ?? null,
            ]
        ];

        parent::__construct($data, 200, 'Transaction reverted successfully');
    }
}

