<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums;

enum TransactionStatus: string
{
    case PENDING   = 'PENDING';
    case COMPLETED = 'COMPLETED';
    case FAILED    = 'FAILED';
    case REVERTED  = 'REVERTED';
}
