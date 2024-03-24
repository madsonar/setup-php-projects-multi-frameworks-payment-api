<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Customer\CreateCustomer;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;

class CustomerUseCase
{
    private CustomerRepositoryContract $customerRepository;

    public function __construct(CustomerRepositoryContract $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function execute(array $data): Customer
    {
        $customer = new Customer(
            id: 0,
            first_name: $data['first_name'],
            last_name: $data['last_name'],
            document: $data['document'],
            email: $data['email'],
            password: $data['password'],
            user_type: $data['user_type']
        );

        return $this->customerRepository->save($customer);
    }
}
