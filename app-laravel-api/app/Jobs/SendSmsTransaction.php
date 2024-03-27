<?php

namespace App\Jobs;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalSendSmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5; // 5 tentativas

    protected array $transactionDetails;

    public function __construct(array $transactionDetails)
    {
        $this->transactionDetails = $transactionDetails;
    }

    public function handle(ExternalSendSmsService $smsService): void
    {
        $result = $smsService->send($this->transactionDetails);

        if (!$result) {
            $this->release(60); // Atraso de 60 segundos
        }
    }

    public function failed(\Throwable $exception): void
    {
    }
}
