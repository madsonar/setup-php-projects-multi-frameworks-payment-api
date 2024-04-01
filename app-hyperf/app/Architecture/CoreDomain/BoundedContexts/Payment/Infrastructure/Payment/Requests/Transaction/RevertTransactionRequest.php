<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction;

use Hyperf\Validation\Request\FormRequest;

use function array_merge;

class RevertTransactionRequest extends FormRequest
{

    public function rules(): array
    {
        return ['transaction_id' => 'required|integer'];//|unique:transactions,reverted_transaction_id'];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function validationData(): array
    {
        return array_merge($this->all(), [
            'transaction_id' => $this->route('transaction_id'),
        ]);
    }
}
