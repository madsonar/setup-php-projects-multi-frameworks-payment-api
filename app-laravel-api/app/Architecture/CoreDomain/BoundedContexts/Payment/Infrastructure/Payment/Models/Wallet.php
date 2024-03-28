<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models;

// @phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
// @phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint

use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['customer_id', 'account_number', 'current_balance', 'account_number'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
