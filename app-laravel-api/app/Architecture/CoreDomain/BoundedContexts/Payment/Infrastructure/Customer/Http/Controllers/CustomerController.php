<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Requests\Customer\CreateCustomerRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Customer\CreateCustomer\CustomerService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Response\Customer\CreateCustomerResponse;

class CustomerController extends Controller
{
    public function create(CreateCustomerRequest $request, CustomerService $customerService)
    {
        $customer = $customerService->createCustomer($request->validated());

        $createCustomerResponse = new CreateCustomerResponse([
            'customer' => $customer
        ], 201, 'Cliente criado com sucesso.');

        return $createCustomerResponse->response();
    }
}
