<?php

declare(strict_types=1);

// @phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
// @phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\CustomerType;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models\Wallet;
use Carbon\Carbon;
use Hyperf\Database\Model\Relations\HasOne;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $document
 * @property string $email
 * @property string $password
 * @property string $user_type
 * @property int $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Customer extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'customers';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'first_name',
        'last_name',
        'document',
        'email',
        'password',
        'user_type',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'id' => 'integer',
        'is_active' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'user_type' => 'string', // Ajuste conforme necessário para suporte ao enum
    ];

    /**
     * Define the relationship with the Wallet model.
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Mutator for the user_type attribute to store enum values.
     */
    public function setUserTypeAttribute($value): void
    {
        $this->attributes['user_type'] = $value instanceof CustomerType ? $value->value : $value;
    }

    /**
     * Accessor for the user_type attribute to retrieve enum instances.
     */
    public function getUserTypeAttribute($value): CustomerType
    {
        return CustomerType::from($value);
    }
}
