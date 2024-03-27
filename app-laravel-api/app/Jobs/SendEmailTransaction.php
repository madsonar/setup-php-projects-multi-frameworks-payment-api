<?php

namespace App\Jobs;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalSendEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    protected array $transactionDetails;

    public function __construct(array $transactionDetails)
    {
        $this->transactionDetails = $transactionDetails;
    }

    public function handle(ExternalSendEmailService $emailService): void
    {
        $result = $emailService->send($this->transactionDetails);

        if (!$result) {
            $this->release(60);
        }
    }

    public function failed(\Throwable $exception): void
    {
    }
}
