<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalSendEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendEmailTransaction implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 5;

    public function __construct(protected array $transactionDetails)
    {
    }

    public function handle(ExternalSendEmailService $emailService): void
    {
        $result = $emailService->send($this->transactionDetails);

        if ($result) {
            return;
        }

        $this->release(60);
    }

    public function failed(Throwable $exception): void
    {
    }
}
