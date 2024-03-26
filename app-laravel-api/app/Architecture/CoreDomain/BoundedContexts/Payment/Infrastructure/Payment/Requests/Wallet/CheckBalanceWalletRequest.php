<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Wallet;

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
        return [
            'customer_id' => 'required|integer|exists:customers,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
