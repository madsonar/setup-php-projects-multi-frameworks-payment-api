<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Models;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\CustomerType;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'document', 'email', 'password', 'user_type', 'is_active'
    ];

    protected $casts = [
        'user_type' => CustomerType::class,
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function setUserTypeAttribute($value)
    {
        $this->attributes['user_type'] = $value instanceof CustomerType ? $value->value : $value;
    }

    public function getUserTypeAttribute($value): CustomerType
    {
        return CustomerType::from($value);
    }
}
