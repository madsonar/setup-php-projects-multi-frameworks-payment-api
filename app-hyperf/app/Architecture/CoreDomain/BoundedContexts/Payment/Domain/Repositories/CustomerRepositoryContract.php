<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer;

interface CustomerRepositoryContract
{
    public function saveWithWallet(Customer $customer): Customer;

    public function findById(int $id): Customer|null;
}
