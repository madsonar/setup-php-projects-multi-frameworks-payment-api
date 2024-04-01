<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions;

use App\Architecture\Shared\Domain\Contracts\Exception\BaseException;

class TransactionNotFound extends BaseException
{
    protected string $msg     = 'Transaction not found.';
    protected int $statusCode = 404;

    public function __construct()
    {
        parent::__construct($this->msg, $this->statusCode);
    }
}
