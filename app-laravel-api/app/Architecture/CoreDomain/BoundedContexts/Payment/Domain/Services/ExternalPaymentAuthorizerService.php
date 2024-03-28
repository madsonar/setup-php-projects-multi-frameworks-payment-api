<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services;

// @phpcs:disable Generic.PHP.ForbiddenFunctions.Found

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;

use function is_null;

class ExternalPaymentAuthorizerService
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    public function authorizeTransaction(string $transactionUuid): bool
    {
        $headers = [];
        $args    = [];

        $responseArray = $this->httpClient->get('/' . $transactionUuid, $headers, $args, 'externalPaymentAuthorizerApi');

        return ! is_null($responseArray) && isset($responseArray['message']) && $responseArray['message'] === 'Autorizado';
    }
}
