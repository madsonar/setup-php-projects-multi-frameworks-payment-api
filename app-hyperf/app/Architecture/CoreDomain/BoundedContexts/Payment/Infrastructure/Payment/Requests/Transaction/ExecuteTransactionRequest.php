<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction;

use Hyperf\Validation\Request\FormRequest;

class ExecuteTransactionRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'payer_id' => 'required|integer|exists:customers,id',
            'payee_id' => 'required|integer|exists:customers,id',
            'value' => 'required|numeric|min:0.01',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
