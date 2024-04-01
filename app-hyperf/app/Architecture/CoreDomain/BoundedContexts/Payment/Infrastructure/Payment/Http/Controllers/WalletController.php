<?php

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Wallet\CheckBalanceWalletService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Wallet\CheckBalanceWalletRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Wallet\CheckBalanceWalletResponse;
use Hyperf\HttpServer\Contract\ResponseInterface as HyperfResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class WalletController
{
    public function __construct(private CheckBalanceWalletService $checkBalanceWalletService)
    {
    }

    public function checkBalanceWallet(CheckBalanceWalletRequest $request, HyperfResponseInterface $hyperResponse): PsrResponseInterface
    {
        $validated  = $request->validated();
        $customerId = (int) $validated['customer_id'];
        $wallet     = $this->checkBalanceWalletService->checkBalance($customerId);

        $response = new CheckBalanceWalletResponse($wallet);

        return $response->response($hyperResponse);
    }
}
