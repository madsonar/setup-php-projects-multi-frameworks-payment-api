<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions;

use App\Architecture\Shared\Domain\Contracts\Exception\BaseException;

class ShopkeeperCannotSend extends BaseException
{
    protected $msg = 'Shopkeepers are not allowed to perform transfers.';
    protected $statusCode = 422;
}
