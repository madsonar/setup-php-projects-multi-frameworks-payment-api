<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Job;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\Jobs\SendSmsJobService;
use App\Job\SendSmsTransaction;
use Hyperf\AsyncQueue\Driver\DriverFactory;

class SendSmsJobAdapter extends SendSmsJobService
{
    public function __construct(protected DriverFactory $driverFactory)
    {
    }

    public function dispatch(array $details): void
    {
        $driver = $this->driverFactory->get('default');

        $driver->push(new SendSmsTransaction($details));
    }
}
