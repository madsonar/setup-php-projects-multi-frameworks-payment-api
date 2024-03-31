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


Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::post('/customers/create', [CustomerController::class, 'create']);

Router::get('/favicon.ico', function () {
    return '';
});
