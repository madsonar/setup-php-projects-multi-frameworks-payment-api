<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction;

// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint

use Illuminate\Foundation\Http\FormRequest;

class ExecuteTransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'payer_id' => 'required|integer|exists:customers,id',
            'payee_id' => 'required|integer|exists:customers,id',
            'value' => 'required|numeric|min:0.01',
        ];
    }

    public function validate(): void
    {
        $this->validateResolved();
    }

    public function authorize()
    {
        return true;
    }
}
