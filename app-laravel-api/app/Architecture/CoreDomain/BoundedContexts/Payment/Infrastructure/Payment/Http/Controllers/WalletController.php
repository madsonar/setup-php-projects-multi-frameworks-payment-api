<?php

// phpcs:ignoreFile

declare(strict_types=1);

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers;

use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Wallet\CheckBalanceWalletService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Wallet\CheckBalanceWalletRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Wallet\CheckBalanceWalletResponse;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function __construct(private CheckBalanceWalletService $checkBalanceWalletService)
    {
    }

    public function checkBalanceWallet(CheckBalanceWalletRequest $request): mixed
    {
        $customerId = $request->input('customer_id');
        $wallet     = $this->checkBalanceWalletService->checkBalance($customerId);

        $response = new CheckBalanceWalletResponse($wallet);

        return $response->response();
    }
}
