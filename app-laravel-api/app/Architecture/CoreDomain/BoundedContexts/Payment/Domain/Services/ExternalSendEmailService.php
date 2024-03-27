<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services;

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;

class ExternalSendEmailService
{
    private HttpClientContract $httpClient;

    public function __construct(HttpClientContract $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function send(array $data): bool
    {
        $headers = [];
    
        $responseArray = $this->httpClient->post('/external-send-email', $headers, $data, 'externalSendEmailSmsApi');
    
        if (!is_null($responseArray) && isset($responseArray['send']) && $responseArray['send'] === true) {
            return true;
        } else {
            return false;
        }
    }
}
