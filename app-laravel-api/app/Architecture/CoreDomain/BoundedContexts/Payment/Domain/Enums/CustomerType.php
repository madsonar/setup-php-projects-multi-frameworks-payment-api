<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums;

enum CustomerType: string
{
    case COMMON     = 'common';
    case SHOPKEEPER = 'shopkeeper';
}
