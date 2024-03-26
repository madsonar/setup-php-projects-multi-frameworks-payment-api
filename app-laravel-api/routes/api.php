<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Http\Controllers\CustomerController;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers\TransactionController;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers\WalletController;

Route::get('/phpinfo', function () {
    ob_start();
    phpinfo();
    $phpinfo = ob_get_clean();
    return response()->make($phpinfo, 200, ['Content-Type' => 'text/html']);
});

Route::post('/customers/create', [CustomerController::class, 'create']);

Route::post('/transactions/execute', [TransactionController::class, 'executeTransaction']);

Route::post('/transactions/revert/{transaction_id}', [TransactionController::class, 'revertTransaction']);

Route::get('/wallets/check-balance/{customer_id}', [WalletController::class, 'checkBalanceWallet'])->name('wallets.checkBalance');