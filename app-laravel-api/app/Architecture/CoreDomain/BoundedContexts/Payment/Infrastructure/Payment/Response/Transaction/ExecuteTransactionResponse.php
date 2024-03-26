<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Transaction;

use App\Architecture\Shared\Application\Contracts\Response\BaseResponse;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;

class ExecuteTransactionResponse extends BaseResponse
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
            ]
        ];

        parent::__construct($data, 201, 'Transaction executed successfully');
    }
}
