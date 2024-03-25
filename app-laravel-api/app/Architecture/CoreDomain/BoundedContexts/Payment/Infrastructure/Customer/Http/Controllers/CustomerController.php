<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Requests\Customer\CreateCustomerRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Customer\CreateCustomer\CreateCustomerService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Response\Customer\CreateCustomerResponse;

class CustomerController extends Controller
{
    public function create(CreateCustomerRequest $request, CreateCustomerService $CreateCustomerService)
    {
        //return response()->json(['message' => 'Hello']);

        $customer = $CreateCustomerService->createCustomer($request->validated());

        $createCustomerResponse = new CreateCustomerResponse([
            'customer' => $customer
        ], 201, 'Cliente criado com sucesso.');

        return $createCustomerResponse->response();
    }

    public function helloo()
    {
        return response()->json(['message' => 'Hello']);
    }
}
