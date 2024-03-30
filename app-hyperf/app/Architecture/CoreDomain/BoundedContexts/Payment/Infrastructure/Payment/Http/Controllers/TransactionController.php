<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Transaction\ExecuteTransactionService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Transaction\RevertTransactionService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\TransactionStatus;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction\ExecuteTransactionRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction\RevertTransactionRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Transaction\ExecuteTransactionResponse;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Transaction\RevertTransactionResponse;
use App\Architecture\Shared\Domain\Helpers\UuidHelper;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function __construct(
        private ExecuteTransactionService $executeTransactionService,
        private RevertTransactionService $revertTransactionService,
    ) {
    }

    public function executeTransaction(ExecuteTransactionRequest $request): mixed
    {
        $transaction = new Transaction(
            id: null,
            payerId: (int) $request->payer_id,
            payeeId: (int) $request->payee_id,
            value: (float) $request->value,
            status: TransactionStatus::PENDING,
            transactionKey: UuidHelper::generateUuid(),
        );

        $executedTransaction = $this->executeTransactionService->execute($transaction);
        $response            = new ExecuteTransactionResponse($executedTransaction);

        return $response->response();
    }

    public function revertTransaction(RevertTransactionRequest $request): mixed
    {
        $transaction_id = (int) $request->input('transaction_id');

        $transaction = $this->revertTransactionService->revert($transaction_id);

        return (new RevertTransactionResponse($transaction))->response();
    }
}
