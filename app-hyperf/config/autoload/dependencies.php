<?php

declare(strict_types=1);

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\WalletRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\Jobs\SendEmailJobService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services\Jobs\SendSmsJobService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Repositories\CustomerRepository;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Job\SendEmailJobAdapter;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Job\SendSmsJobAdapter;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Repositories\TransactionRepository;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Repositories\WalletRepository;
use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;
use App\Architecture\Shared\Infrastructure\Adapters\Http\Client\Laravel\HttpClientLaravel;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 *
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 */
return [
    //Reposotories
    CustomerRepositoryContract::class => CustomerRepository::class,
    TransactionRepositoryContract::class => TransactionRepository::class,
    WalletRepositoryContract::class => WalletRepository::class,

    //HttpClient
//    HttpClientContract::class => HttpClientLaravel::class,

    //Jobs
    //SendEmailJobService::class => SendEmailJobAdapter::class,
    //SendSmsJobService::class => SendSmsJobAdapter::class,
];
