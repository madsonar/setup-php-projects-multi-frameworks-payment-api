<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;

interface CustomerRepositoryContract
{
    public function save(Customer $customer): Customer;
}
