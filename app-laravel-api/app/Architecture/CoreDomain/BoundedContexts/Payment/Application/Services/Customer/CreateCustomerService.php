<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Customer;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\UseCases\Customer\CreateCustomerUseCase;

class CreateCustomerService
{
    public function __construct(private CreateCustomerUseCase $createCustomerUseCase)
    {
    }

    public function createCustomer(Customer $customer): Customer
    {
        return $this->createCustomerUseCase->execute($customer);
    }
}
