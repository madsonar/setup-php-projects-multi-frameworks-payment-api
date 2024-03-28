<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Transaction;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Transaction;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions\ShopkeeperCannotSend;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions\TransactionNotAuthorized;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalPaymentAuthorizerService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\Jobs\SendEmailJobService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\Jobs\SendSmsJobService;
use App\Architecture\Shared\Domain\Helpers\UuidHelper;

class ExecuteTransactionUseCase
{
    public function __construct(
        private TransactionRepositoryContract $transactionRepository,
        private CustomerRepositoryContract $customerRepository,
        private ExternalPaymentAuthorizerService $paymentAuthorizer,
        private SendEmailJobService $sendEmailJobService,
        private SendSmsJobService $sendSmsJobService,
    ) {
    }

    public function execute(Transaction $transaction): Transaction
    {
        $this->validatePayer($transaction->payerId);

        $transactionKey = $this->authorizeTransaction();
        $transaction->setTransactionKey($transactionKey);

        $executedTransaction = $this->transactionRepository->executeTransaction($transaction);

        $emailData = $this->prepareEmailData($transaction);
        $smsData   = $this->prepareSmsData($transaction);

        $this->sendEmailJobService->dispatch($emailData);
        $this->sendSmsJobService->dispatch($smsData);

        return $executedTransaction;
    }

    private function validatePayer(int $payerId): void
    {
        $payer = $this->customerRepository->findById($payerId);

        if ($payer->isShopkeeper()) {
            throw new ShopkeeperCannotSend();
        }
    }

    private function authorizeTransaction(): string
    {
        $transactionKey = UuidHelper::generateUuid();

        if (! $this->paymentAuthorizer->authorizeTransaction($transactionKey)) {
            throw new TransactionNotAuthorized();
        }

        return $transactionKey;
    }

    private function prepareEmailData(Transaction $transaction): array
    {
        $payer = $this->customerRepository->findById($transaction->payerId);

        return [
            'transactionId' => $transaction->getId(),
            'amount' => $transaction->getValue(),
            'senderName' => $payer->getFullName(),
            'message' => "Você recebeu um pagamento de {$payer->getFullName()} no valor de {$transaction->getValue()}",
            'receiverEmail' => $payer->getEmail(),
            'subject' => 'Recebimento de pagamento',
        ];
    }

    private function prepareSmsData(Transaction $transaction): array
    {
        $payer = $this->customerRepository->findById($transaction->payerId);

        return [
            'transactionId' => $transaction->getId(),
            'message' => "Você recebeu um pagamento de {$payer->getFullName()} no valor de {$transaction->getValue()}. Transação: {$transaction->getId()}",
        ];
    }
}
