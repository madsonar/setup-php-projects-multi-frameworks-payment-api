<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Customer\CreateCustomerService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\CustomerType;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Requests\Customer\CreateCustomerRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Response\Customer\CreateCustomerResponse;

class CustomerController extends Controller
{
    private CreateCustomerService $createCustomerService;

    public function __construct(CreateCustomerService $createCustomerService)
    {
        $this->createCustomerService = $createCustomerService;
    }

    public function create(CreateCustomerRequest $request)
    {
        $customerData = $request->validated();

        $customer = new Customer(
            id: null,
            first_name: $customerData['first_name'],
            last_name: $customerData['last_name'],
            document: $customerData['document'],
            email: $customerData['email'],
            password: bcrypt($customerData['password']),
            user_type: CustomerType::from($customerData['user_type'])
        );

        $savedCustomer = $this->createCustomerService->createCustomer($customer);

        return (new CreateCustomerResponse($savedCustomer))->response();
    }
}
