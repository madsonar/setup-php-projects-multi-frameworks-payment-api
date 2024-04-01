<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Http\Controllers\CustomerController;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers\TransactionController;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Http\Controllers\WalletController;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::post('/customers/create', [CustomerController::class, 'create']);

Router::post('/transactions/execute', [TransactionController::class, 'executeTransaction']);

Router::post('/transactions/revert/{transaction_id}', [TransactionController::class, 'revertTransaction']);

Router::get('/wallets/check-balance/{customer_id}', [WalletController::class, 'checkBalanceWallet'], ['name' => 'wallets.checkBalance']);

Router::get('/favicon.ico', function () {
    return '';
});
