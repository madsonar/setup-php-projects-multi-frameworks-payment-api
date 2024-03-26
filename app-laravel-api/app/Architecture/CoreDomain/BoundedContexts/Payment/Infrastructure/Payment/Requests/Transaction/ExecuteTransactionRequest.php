<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class ExecuteTransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'payer_id' => 'required|integer',
            'payee_id' => 'required|integer',
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
