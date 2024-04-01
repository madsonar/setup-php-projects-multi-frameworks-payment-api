<?php

// phpcs:ignoreFile

namespace App\Architecture\Shared\Domain\Contracts\HttpClient;

interface HttpClientContract
{
    public function get(string $baseUrl, string $uri, array $headers = [], array $args = []): ?array;
    public function post(string $baseUrl, string $uri, array $headers = [], array $data = []): ?array;
}