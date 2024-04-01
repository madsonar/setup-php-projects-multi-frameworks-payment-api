<?php

declare(strict_types=1);

namespace App\Job;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalSendSmsService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Di\Annotation\Inject;

class SendSmsTransaction extends Job
{
    /** @Inject */
    private ExternalSendSmsService $smsService;

    public function __construct(protected array $params)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        var_dump('##########>>>>>>>>SMS [ENVIANDO]');
        $this->smsService->send($this->params);
    }
}
