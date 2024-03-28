<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Http\Controllers;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Customer\CreateCustomerService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\CustomerType;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Requests\Customer\CreateCustomerRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Response\Customer\CreateCustomerResponse;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function __construct(private CreateCustomerService $createCustomerService)
    {
    }

    public function create(CreateCustomerRequest $request): mixed
    {
        $customerData = $request->validated();

        $customer = new Customer(
            id: null,
            first_name: $customerData['first_name'],
            last_name: $customerData['last_name'],
            document: $customerData['document'],
            email: $customerData['email'],
            password: bcrypt($customerData['password']),
            user_type: CustomerType::from($customerData['user_type']),
        );

        $savedCustomer = $this->createCustomerService->createCustomer($customer);

        return (new CreateCustomerResponse($savedCustomer))->response();
    }
}
