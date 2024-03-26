<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Customer;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;

class CreateCustomerUseCase {
    private CustomerRepositoryContract $customerRepository;

    public function __construct(CustomerRepositoryContract $customerRepository) {
        $this->customerRepository = $customerRepository;
    }

    public function execute(Customer $customer): Customer {
        return $this->customerRepository->saveWithWallet($customer);
    }
}
