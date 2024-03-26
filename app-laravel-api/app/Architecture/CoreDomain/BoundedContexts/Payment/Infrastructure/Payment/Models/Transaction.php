<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\TransactionStatus;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models\Customer;

class Transaction extends Model
{
    protected $fillable = ['transaction_key', 'payer_id', 'payee_id', 'value', 'status', 'reverted_transaction_id'];

    public function payer()
    {
        return $this->belongsTo(Customer::class, 'payer_id');
    }

    public function payee()
    {
        return $this->belongsTo(Customer::class, 'payee_id');
    }

    public function setStatusAttribute($value) {
        $this->attributes['status'] = $value instanceof TransactionStatus ? $value->value : $value;
    }

    public function getStatusAttribute($value): TransactionStatus {
        return TransactionStatus::from($value);
    }

    public function revertedTransaction()
    {
        return $this->belongsTo(self::class, 'reverted_transaction_id');
    }
}
