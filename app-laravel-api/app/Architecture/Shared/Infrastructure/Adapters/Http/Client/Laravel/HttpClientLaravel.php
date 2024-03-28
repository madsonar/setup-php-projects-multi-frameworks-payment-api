<?php

namespace App\Architecture\Shared\Infrastructure\Adapters\Http\Client\Laravel;

use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;

class HttpClientLaravel implements HttpClientContract
{
    public function get(string $uri, array $headers = [], array $args = [], string $macroName): ?array
    {
        try {
            $response = Http::{$macroName}()->withHeaders($headers)->retry(
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

    public function post(string $uri, array $headers = [], array $data = [], string $macroName): ?array
    {
        try {
            $response = Http::{$macroName}()->withHeaders($headers)->retry(
                env('API_EXTERNAL_SEND_EMAIL_SMS_MAX_CONNECTION_RETRIES', 1),
                env('API_EXTERNAL_SEND_EMAIL_SMS_CONNECTION_RETRIES_INTERVAL', 1000)
            )->post($uri, $data);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new RequestException($response);
            }
        } catch (Throwable $throwable) {
            return $this->handleResponse($throwable);
        }
    }

    protected function handleResponse(Throwable $throwable): ?array
    {
        if ($throwable instanceof RequestException) {
            // Supondo que $throwable->response->json() retorne um array ou null
            $response = $throwable->response->json();
            return $response; // Garante que retorna um array ou null
        } elseif ($throwable instanceof ConnectionException) {
            // Retorna um array em caso de exceção de conexão
            return ['error' => 'Connection error', 'details' => $throwable->getMessage()];
        } else {
            // Retorna um array para outros tipos de exceções
            return ['error' => 'Unexpected error', 'details' => $throwable->getMessage()];
        }
    }
}
