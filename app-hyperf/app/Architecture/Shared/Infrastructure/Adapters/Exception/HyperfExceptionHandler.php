<?php

declare(strict_types=1);

namespace App\Architecture\Shared\Infrastructure\Adapters\Exception;

use App\Architecture\Shared\Domain\Contracts\Exception\ExceptionContract;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

use function Hyperf\Support\env;

class HyperfExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): mixed
    {
        $this->stopPropagation();

        if ($throwable instanceof ValidationException) {
            $statusCode = 422;
            $message    = 'The given data was invalid.';
            $errors     = $throwable->validator->errors()->getMessages();

            $data = ['errors' => $errors];
        } else {
            $statusCode = $throwable instanceof ExceptionContract ? $throwable->getStatusCode() : 500;
            $message    = $throwable->getMessage();
            $data       = $throwable instanceof ExceptionContract ? $throwable->getResponseData() : [];
        }

        if (env('APP_ENV') === 'dev') {
            $data['trace'] = $throwable->getTrace();
        }

        $errorResponse = new ErrorResponse($message, $statusCode, $data);

        return $errorResponse->response($response);
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
