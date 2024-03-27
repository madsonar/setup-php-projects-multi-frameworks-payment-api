<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Job;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\Jobs\SendSmsJobService;
use App\Jobs\SendSmsTransaction;

class SendSmsJobAdapter extends SendSmsJobService
{
    public function dispatch(array $details): void
    {
        SendSmsTransaction::dispatch($details)->onQueue('sms');
    }
}
