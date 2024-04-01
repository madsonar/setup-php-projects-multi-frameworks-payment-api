<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Wallet;

use Hyperf\Validation\Request\FormRequest;

class CheckBalanceWalletRequest extends FormRequest
{

    public function rules(): array
    {
        return ['customer_id' => 'required|integer|exists:customers,id'];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function validationData(): array
    {
        $all                = $this->all();
        $all['customer_id'] = $this->route('customer_id');

        return $all;
    }
}
