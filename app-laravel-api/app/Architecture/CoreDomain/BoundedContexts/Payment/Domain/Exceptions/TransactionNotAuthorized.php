<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions;

use App\Architecture\Shared\Domain\Contracts\Exception\BaseException;

class TransactionNotAuthorized extends BaseException
{
    protected $msg = 'Transaction not authorized.';
    protected $statusCode = 403;
}
