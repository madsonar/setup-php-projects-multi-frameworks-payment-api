<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Repositories;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Entities\Customer as DomainCustomer;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models\Customer as ModelCustomer;

class CustomerRepository implements CustomerRepositoryContract
{
    public function save(DomainCustomer $domainCustomer): DomainCustomer
    {
        $modelCustomer = ModelCustomer::create([
            'first_name' => $domainCustomer->first_name,
            'last_name'  => $domainCustomer->last_name,
            'document'   => $domainCustomer->document,
            'email'      => $domainCustomer->email,
            'password'   => bcrypt($domainCustomer->password),
            'user_type'  => $domainCustomer->user_type,
        ]);

        // Atualiza a entidade do domínio com o ID atribuído pelo Eloquent.
        $domainCustomer->id = $modelCustomer->id;
        return $domainCustomer;
    }
}

