<?php

namespace App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Application\Services\Wallet\CheckBalanceWalletService;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Requests\Wallet\CheckBalanceWalletRequest;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Response\Wallet\CheckBalanceWalletResponse;

class WalletController extends Controller
{
    private CheckBalanceWalletService $checkBalanceWalletService;

    public function __construct(CheckBalanceWalletService $checkBalanceWalletService)
    {
        $this->checkBalanceWalletService = $checkBalanceWalletService;
    }

    public function checkBalanceWallet(CheckBalanceWalletRequest $request): mixed
    {
        $customerId = $request->input('customer_id');
        $wallet = $this->checkBalanceWalletService->checkBalance($customerId);

        $response = new CheckBalanceWalletResponse($wallet);

        return $response->response();
    }
}
