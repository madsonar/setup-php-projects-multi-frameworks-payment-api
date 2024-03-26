<?php

namespace App\Architecture\Shared\Infrastructure\Adapters\Http\Client\Laravel;

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;

class HttpClientLaravel implements HttpClientContract
{
    public function get(string $uri, array $headers = [], array $args = []): ?array
    {
        try {
            $response = Http::externalPaymentAuthorizerApi()->withHeaders($headers)->retry(
                env('API_EXTERNAL_PAYMENT_AUTHORIZER_MAX_CONNECTION_RETRIES', 1),
                env('API_EXTERNAL_PAYMENT_AUTHORIZER_CONNECTION_RETRIES_INTERVAL', 1000)
            )->get($uri, $args);
            
            if ($response->successful()) {
                return $response->json();
            } else {
                throw new RequestException($response);
            }
        } catch (Throwable $throwable) {
            return $this->handleResponse($throwable);
        }
    }

    public function post(string $uri, array $data = [], array $headers = []): ?array
    {
        return [];
    }

    protected function handleResponse(Throwable $throwable): ?array
    {
        if ($throwable instanceof RequestException) {
            $response = $throwable->response->json();

            return $response;
        } elseif ($throwable instanceof ConnectionException) {
            return ['error' => 'Connection error', 'details' => $throwable->getMessage()];
        } else {
            return ['error' => 'Unexpected error', 'details' => $throwable->getMessage()];
        }
    }
}
