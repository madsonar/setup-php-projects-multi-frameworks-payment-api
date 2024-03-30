<?php

// phpcs:ignoreFile

namespace App\Architecture\Shared\Domain\Contracts\HttpClient;

interface HttpClientContract
{
    public function get(string $uri, array $headers = [], array $args = [], string $macroName): ?array;
    public function post(string $uri, array $headers = [], array $data = [], string $macroName): ?array;
}

