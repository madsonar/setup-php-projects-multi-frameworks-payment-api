<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Customer\CreateCustomer;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Customer\CreateCustomer\CreateCustomerUseCase;

class CreateCustomerService
{
    private CreateCustomerUseCase $CreateCustomerUseCase;

    public function __construct(CreateCustomerUseCase $CreateCustomerUseCase)
    {
        $this->CreateCustomerUseCase = $CreateCustomerUseCase;
    }

    public function createCustomer(array $data)
    {
        return $this->CreateCustomerUseCase->execute($data);
    }
}
