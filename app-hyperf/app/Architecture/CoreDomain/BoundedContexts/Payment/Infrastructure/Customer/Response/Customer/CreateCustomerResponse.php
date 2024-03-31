<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Response\Customer;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;
use App\Architecture\Shared\Infrastructure\Contracts\Response\BaseResponse;

class CreateCustomerResponse extends BaseResponse
{
    public function __construct(Customer $customer)
    {
        $data = [
            'customer' => [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'document' => $customer->document,
                'email' => $customer->email,
                'user_type' => $customer->user_type->value,
                'wallet' => [
                    'account_number' => $customer->wallet->accountNumber,
                    'current_balance' => $customer->wallet->currentBalance,
                ],
            ],
        ];

        parent::__construct($data, 201, 'Customer created successfully');
    }
}
