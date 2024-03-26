<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions;

use App\Architecture\Shared\Domain\Contracts\Exception\BaseException;

class InsufficientFunds extends BaseException
{
    protected $msg = 'Transaction cannot be completed due to insufficient funds.';
    protected $statusCode = 422;
}

