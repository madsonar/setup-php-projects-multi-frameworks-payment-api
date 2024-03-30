<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Wallet;

// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint

use Illuminate\Foundation\Http\FormRequest;

class CheckBalanceWalletRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'customer_id' => $this->route('customer_id'),
        ]);
    }

    public function rules()
    {
        return ['customer_id' => 'required|integer|exists:customers,id'];
    }

    public function authorize()
    {
        return true;
    }
}
