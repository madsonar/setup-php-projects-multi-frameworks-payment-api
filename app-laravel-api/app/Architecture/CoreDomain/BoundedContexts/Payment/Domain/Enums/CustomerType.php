<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums;

enum CustomerType: string
{
    case COMMON = 'common';
    case SHOPKEEPER = 'shopkeeper';
}
