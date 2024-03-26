<?php

namespace App\Architecture\Shared\Domain\Contracts\HttpClient;

interface HttpClientContract
{
    public function get(string $uri, array $headers = []): ?array;
    public function post(string $uri, array $data = [], array $headers = []): ?array;
}

