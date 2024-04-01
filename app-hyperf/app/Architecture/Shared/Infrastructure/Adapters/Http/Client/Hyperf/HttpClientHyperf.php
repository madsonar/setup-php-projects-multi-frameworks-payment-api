<?php

namespace App\Architecture\Shared\Infrastructure\Adapters\Http\Client\Hyperf;

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;
use Hyperf\Guzzle\ClientFactory;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpClientHyperf implements HttpClientContract
{
    public function __construct(protected ClientFactory $clientFactory)
    {
    }

    public function get(string $baseUrl, string $uri, array $headers = [], array $args = []): ?array
    {
        $client = $this->clientFactory->create(['base_uri' => $baseUrl]);
        try {
            $response = $client->get($uri, [
                'headers' => $headers,
                'query' => $args,
            ]);

            return $this->processResponse($response);
        } catch (Throwable $throwable) {
            return $this->handleResponse($throwable);
        }
    }

    public function post(string $baseUrl, string $uri, array $headers = [], array $data = []): ?array
    {
        $client = $this->clientFactory->create(['base_uri' => $baseUrl]);
        try {
            $response = $client->post($uri, [
                'headers' => $headers,
                'json' => $data,
            ]);

            return $this->processResponse($response);
        } catch (Throwable $throwable) {
            return $this->handleResponse($throwable);
        }
    }

    protected function processResponse(ResponseInterface $response): ?array
    {
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return json_decode($response->getBody()->getContents(), true);
        }

        throw new RequestException($response, "Request failed with status {$response->getStatusCode()}.");
    }

    protected function handleResponse(Throwable $throwable): ?array
    {
        if ($throwable instanceof RequestException || $throwable instanceof ConnectException) {
            return ['error' => 'Request failed', 'details' => $throwable->getMessage()];
        }

        return ['error' => 'Unexpected error', 'details' => $throwable->getMessage()];
    }
}
