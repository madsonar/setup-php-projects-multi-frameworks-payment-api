<?php

// phpcs:ignoreFile

declare(strict_types=1);

namespace App\Architecture\Shared\Infrastructure\Contracts\Response;

use App\Architecture\Shared\Application\Contracts\Response\ResponseContract;
use Symfony\Component\HttpFoundation\Response;
//use Hyperf\HttpServer\Contract\ResponseInterface as HyperfResponseInterface;
//use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HyperfResponseInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;


abstract class BaseResponse implements ResponseContract
{
    public function __construct(protected array $data = [], protected int $statusCode = Response::HTTP_OK, protected string $message = '')
    {
    }

    public function response(PsrResponseInterface $response): PsrResponseInterface
    {
        $response = $response->withStatus($this->statusCode)
                             ->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode([
            'data' => $this->data,
            'message' => $this->message ?: 'Operation successful',
        ]));

        return $response;
    }
}
