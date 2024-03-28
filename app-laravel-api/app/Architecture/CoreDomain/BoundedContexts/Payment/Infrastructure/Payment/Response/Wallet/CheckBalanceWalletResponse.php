<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Wallet;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Wallet;
use App\Architecture\Shared\Application\Contracts\Response\BaseResponse;

class CheckBalanceWalletResponse extends BaseResponse
{
    public function __construct(Wallet $wallet)
    {
        $data = [
            'wallet' => [
                'id' => $wallet->id,
                'customer_id' => $wallet->customerId,
                'account_number' => $wallet->accountNumber,
                'current_balance' => $wallet->currentBalance,
            ],
        ];

        parent::__construct($data, 200, 'Current balance!');
    }
}
