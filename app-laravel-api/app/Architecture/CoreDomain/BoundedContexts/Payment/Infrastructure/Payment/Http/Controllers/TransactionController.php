<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Transaction\ExecuteTransactionService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Transaction\RevertTransactionService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction\ExecuteTransactionRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Transaction\ExecuteTransactionResponse;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\TransactionStatus;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Transaction\RevertTransactionResponse;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction\RevertTransactionRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function __construct(
        private ExecuteTransactionService $executeTransactionService,
        private RevertTransactionService $revertTransactionService
    ) {

    }

    public function executeTransaction(ExecuteTransactionRequest $request)
    {
        $transaction = new Transaction(
            id: null,
            payerId: $request->payer_id,
            payeeId: $request->payee_id,
            value: $request->value,
            status: TransactionStatus::PENDING,
            transactionKey: Str::uuid()
        );

        $executedTransaction = $this->executeTransactionService->execute($transaction);
        $response = new ExecuteTransactionResponse($executedTransaction);
        return $response->response();
    }

    public function revertTransaction(RevertTransactionRequest $request)
    {
        $transaction_id = $request->input('transaction_id');

        $transaction = $this->revertTransactionService->revert($transaction_id);
        return (new RevertTransactionResponse($transaction))->response();
    }
}


