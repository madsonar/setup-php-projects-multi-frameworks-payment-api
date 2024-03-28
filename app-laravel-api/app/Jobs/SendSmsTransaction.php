<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalSendSmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendSmsTransaction implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 5; // 5 tentativas

    public function __construct(protected array $transactionDetails)
    {
    }

    public function handle(ExternalSendSmsService $smsService): void
    {
        $result = $smsService->send($this->transactionDetails);

        if ($result) {
            return;
        }

        $this->release(60); // Atraso de 60 segundos
    }

    public function failed(Throwable $exception): void
    {
    }
}
