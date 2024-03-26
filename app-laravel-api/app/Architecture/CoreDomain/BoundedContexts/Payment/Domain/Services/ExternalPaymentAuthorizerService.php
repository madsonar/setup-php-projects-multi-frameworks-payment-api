<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services;

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;

class ExternalPaymentAuthorizerService
{
    private HttpClientContract $httpClient;

    public function __construct(HttpClientContract $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function authorizeTransaction(string $transactionUuid): bool
    {
        $headers = [];
        $args = [];
    
        $responseArray = $this->httpClient->get($transactionUuid, $headers, $args);
    
        if (!is_null($responseArray) && isset($responseArray['message']) && $responseArray['message'] === 'Autorizado') {
            return true;
        } else {
            return false;
        }
    }
}
