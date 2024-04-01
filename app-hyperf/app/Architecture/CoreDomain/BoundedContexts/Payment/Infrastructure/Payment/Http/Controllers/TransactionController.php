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
use Hyperf\HttpServer\Contract\ResponseInterface as HyperfResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class TransactionController
{
    public function __construct(
        private ExecuteTransactionService $executeTransactionService,
        private RevertTransactionService $revertTransactionService,
    ) {
    }

    public function executeTransaction(ExecuteTransactionRequest $request, HyperfResponseInterface $hyperResponse): PsrResponseInterface
    {
        $validated = $request->validated();

        $transaction = new Transaction(
            id: null,
            payerId: (int) $validated['payer_id'],
            payeeId: (int) $validated['payee_id'],
            value: (float) $validated['value'],
            status: TransactionStatus::PENDING,
            transactionKey: UuidHelper::generateUuid(),
        );

        $executedTransaction = $this->executeTransactionService->execute($transaction);
        $response            = new ExecuteTransactionResponse($executedTransaction);

        return $response->response($hyperResponse);
    }

    public function revertTransaction(RevertTransactionRequest $request, HyperfResponseInterface $hyperResponse): PsrResponseInterface
    {
        $validated     = $request->validated();
        $transactionId = (int) $validated['transaction_id'];

        $transaction = $this->revertTransactionService->revert($transactionId);

        $response = new RevertTransactionResponse($transaction);

        return $response->response($hyperResponse);
    }
}
