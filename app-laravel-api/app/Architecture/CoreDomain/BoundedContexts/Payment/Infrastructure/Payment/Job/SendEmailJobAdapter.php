<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Job;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\Jobs\SendEmailJobService;
use App\Jobs\SendEmailTransaction;

class SendEmailJobAdapter extends SendEmailJobService
{
    public function dispatch(array $details): void
    {
        SendEmailTransaction::dispatch($details)->onQueue('emails');
    }
}
