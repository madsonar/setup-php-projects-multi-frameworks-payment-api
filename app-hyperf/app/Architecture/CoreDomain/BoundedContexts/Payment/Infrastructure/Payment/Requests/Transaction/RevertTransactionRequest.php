<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction;

// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint

use Illuminate\Foundation\Http\FormRequest;

class RevertTransactionRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'transaction_id' => $this->route('transaction_id'),
        ]);
    }

    public function rules()
    {
        return ['transaction_id' => 'required|integer|unique:transactions,reverted_transaction_id'];
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
