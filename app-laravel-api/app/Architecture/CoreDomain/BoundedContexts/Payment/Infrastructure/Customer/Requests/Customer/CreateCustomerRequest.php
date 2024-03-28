<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Requests\Customer;

// @phpcs:disable SlevomatCodingStandard.Functions.ArrowFunctionDeclaration.IncorrectSpacesAfterKeyword
// @phpcs:disable SlevomatCodingStandard.Functions.StaticClosure.ClosureNotStatic

use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Enums\CustomerType;
use Illuminate\Foundation\Http\FormRequest;

use function array_map;
use function implode;

class CreateCustomerRequest extends FormRequest
{
    public function rules(): array
    {
        $userTypes       = array_map(fn($case) => $case->value, CustomerType::cases());
        $userTypesString = implode(',', $userTypes);

        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'document'   => 'required|string|max:255|unique:customers,document',
            'email'      => 'required|string|email|max:255|unique:customers,email',
            'password'   => 'required|string|min:6',
            'user_type'  => 'required|string|in:' . $userTypesString,
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return ['user_type.in' => 'The selected user type is invalid.'];
    }
}
