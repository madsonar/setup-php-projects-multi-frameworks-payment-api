<?php

declare(strict_types=1);

namespace App\Job;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\ExternalSendEmailService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Di\Annotation\Inject;


class SendEmailTransaction extends Job
{
    /** @Inject */
    private ExternalSendEmailService $emailService;

    public function __construct(private array $params)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        var_dump('##########>>>>>>>>Email [ENVIANDO]');
        $this->emailService->send($this->params);
    }
}
