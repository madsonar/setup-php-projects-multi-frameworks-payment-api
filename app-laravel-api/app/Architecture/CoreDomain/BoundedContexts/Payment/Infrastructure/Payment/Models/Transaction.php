<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models;

// @phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
// @phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\TransactionStatus;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Model;

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

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value instanceof TransactionStatus ? $value->value : $value;
    }

    public function getStatusAttribute($value): TransactionStatus
    {
        return TransactionStatus::from($value);
    }

    public function revertedTransaction()
    {
        return $this->belongsTo(self::class, 'reverted_transaction_id');
    }
}
