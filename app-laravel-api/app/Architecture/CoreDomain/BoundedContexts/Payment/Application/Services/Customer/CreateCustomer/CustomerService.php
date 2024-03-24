<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Customer\CreateCustomer;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Customer\CreateCustomer\CustomerUseCase;

class CustomerService
{
    private CustomerUseCase $customerUseCase;

    public function __construct(CustomerUseCase $customerUseCase)
    {
        $this->customerUseCase = $customerUseCase;
    }

    public function createCustomer(array $data)
    {
        return $this->customerUseCase->execute($data);
    }
}
