<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Requests\Customer;

use App\Architecture\Shared\Application\Contracts\Request\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest implements RequestInterface
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'document'   => 'required|string|max:255|unique:customers,document',
            'email'      => 'required|string|email|max:255|unique:customers,email',
            'password'   => 'required|string|min:6',
            'user_type'  => 'required|string|in:common,shopkeeper',
        ];
    }

    public function validate(): void
    {
        $this->validateResolved();
    }
}
