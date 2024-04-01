<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Exceptions;

use App\Architecture\Shared\Domain\Contracts\Exception\BaseException;

class TransactionAlreadyReverted extends BaseException
{
    protected string $msg     = 'This transaction has already been reverted.';
    protected int $statusCode = 422;

    public function __construct()
    {
        parent::__construct($this->msg, $this->statusCode);
    }
}
