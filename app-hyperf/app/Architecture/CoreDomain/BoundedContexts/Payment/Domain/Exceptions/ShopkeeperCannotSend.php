<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions;

use App\Architecture\Shared\Domain\Contracts\Exception\BaseException;

class ShopkeeperCannotSend extends BaseException
{
    protected string $msg     = 'Shopkeepers are not allowed to perform transfers.';
    protected int $statusCode = 422;
}
