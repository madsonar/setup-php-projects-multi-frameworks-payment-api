<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Services;

// @phpcs:disable Generic.PHP.ForbiddenFunctions.Found

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;
use Hyperf\Contract\ConfigInterface;

use function is_null;

class ExternalSendEmailService
{
    private string $baseUrl;

    public function __construct(private HttpClientContract $httpClient, ConfigInterface $config)
    {
        $this->baseUrl = $config->get('external_send_email_sms.service_send_email_sms.base_url');
    }

    public function send(array $data): bool
    {
        $responseArray = $this->httpClient->post($this->baseUrl . '/external-send-email', [], $data);

        return ! is_null($responseArray) && isset($responseArray['send']) && $responseArray['send'] === true;
    }
}
