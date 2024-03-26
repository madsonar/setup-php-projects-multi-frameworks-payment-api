<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Customer;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Customer\CreateCustomerUseCase;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;

class CreateCustomerService {
    private CreateCustomerUseCase $createCustomerUseCase;

    public function __construct(CreateCustomerUseCase $createCustomerUseCase) {
        $this->createCustomerUseCase = $createCustomerUseCase;
    }

    public function createCustomer(Customer $customer): Customer {
        return $this->createCustomerUseCase->execute($customer);
    }
}

