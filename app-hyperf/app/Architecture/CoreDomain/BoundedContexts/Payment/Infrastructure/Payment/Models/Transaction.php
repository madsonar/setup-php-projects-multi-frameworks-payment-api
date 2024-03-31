<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models;

// @phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
// @phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\TransactionStatus;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models\Customer;
use Carbon\Carbon;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id
 * @property string $transaction_key
 * @property int $payer_id
 * @property int $payee_id
 * @property string $value
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $reverted_transaction_id
 */
class Transaction extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['transaction_key', 'payer_id', 'payee_id', 'value', 'status', 'reverted_transaction_id'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'id' => 'integer',
        'payer_id' => 'integer',
        'payee_id' => 'integer',
        'value' => 'decimal:2',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'reverted_transaction_id' => 'integer',
    ];

    /**
     * Define the relationship with the Customer model as payer.
     */
    public function payer()
    {
        return $this->belongsTo(Customer::class, 'payer_id');
    }

    /**
     * Define the relationship with the Customer model as payee.
     */
    public function payee()
    {
        return $this->belongsTo(Customer::class, 'payee_id');
    }

    /**
     * Define the relationship with Transaction model for reverted transactions.
     */
    public function revertedTransaction()
    {
        return $this->belongsTo(self::class, 'reverted_transaction_id');
    }

    /**
     * Mutator for the status attribute to store enum values.
     */
    public function setStatusAttribute($value): void
    {
        $this->attributes['status'] = $value instanceof TransactionStatus ? $value->value : $value;
    }

    /**
     * Accessor for the status attribute to retrieve enum instances.
     */
    public function getStatusAttribute($value): TransactionStatus
    {
        return TransactionStatus::from($value);
    }
}
