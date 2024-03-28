<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions;

use App\Architecture\Shared\Domain\Contracts\Exception\BaseException;

class TransactionNotAuthorized extends BaseException
{
    protected string $msg     = 'Transaction not authorized.';
    protected int $statusCode = 403;
}
