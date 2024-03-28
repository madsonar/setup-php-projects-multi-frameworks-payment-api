<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services;

// @phpcs:disable Generic.PHP.ForbiddenFunctions.Found

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;

use function is_null;

class ExternalSendSmsService
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    public function send(array $data): bool
    {
        $headers = [];

        $responseArray = $this->httpClient->post('/external-send-sms', $headers, $data, 'externalSendEmailSmsApi');

        return ! is_null($responseArray) && isset($responseArray['send']) && $responseArray['send'] === true;
    }
}
