<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Customer;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;

class CreateCustomerUseCase
{
    public function __construct(private CustomerRepositoryContract $customerRepository)
    {
    }

    public function execute(Customer $customer): Customer
    {
        return $this->customerRepository->saveWithWallet($customer);
    }
}
