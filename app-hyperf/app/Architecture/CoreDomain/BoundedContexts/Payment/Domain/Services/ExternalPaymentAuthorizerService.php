<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services;

// @phpcs:disable Generic.PHP.ForbiddenFunctions.Found

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;
use Hyperf\Contract\ConfigInterface;

use function is_null;

class ExternalPaymentAuthorizerService
{
    private string $baseUrl;

    public function __construct(
        private HttpClientContract $httpClient,
        private ConfigInterface $config,
    ) {
        $this->baseUrl = $this->config->get('external_payment_authorizer.service_authorizer.base_url');
    }

    public function authorizeTransaction(string $transactionUuid): bool
    {
        $uri           = '/external-payment-authorizer' . '/' . $transactionUuid;
        $responseArray = $this->httpClient->get($this->baseUrl, $uri, [], []);

        return ! is_null($responseArray) && isset($responseArray['message']) && $responseArray['message'] === 'Autorizado';
    }
}
