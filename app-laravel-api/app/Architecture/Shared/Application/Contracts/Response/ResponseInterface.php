<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Application\Contracts\Response;

interface ResponseInterface
{
    public function __construct(iterable|array $data, int $statusCode = 200, string $msg = "");

    public function getData(): iterable|array;

    public function getMessage(): string;

    public function getStatusCode(): int;

    /**
     * Método para construir a resposta de maneira genérica, permitindo implementação específica
     * na camada de infraestrutura.
     * 
     * @return mixed A representação da resposta, que pode ser formatada de acordo com a implementação.
     */
    public function response();
}
