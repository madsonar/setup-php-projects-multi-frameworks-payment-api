<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions;

use App\Architecture\Shared\Domain\Contracts\Exception\BaseException;

class InsufficientFunds extends BaseException
{
    protected string $msg     = 'Transaction cannot be completed due to insufficient funds.';
    protected int $statusCode = 422;
}
