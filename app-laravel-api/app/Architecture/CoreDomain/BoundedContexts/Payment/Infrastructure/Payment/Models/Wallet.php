<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models\Customer;

class Wallet extends Model
{
    protected $fillable = ['customer_id', 'account_number', 'current_balance', 'account_number'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
