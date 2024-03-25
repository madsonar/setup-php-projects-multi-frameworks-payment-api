<?php

use Illuminate\Support\Facades\Route;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Http\Controllers\CustomerController;

Route::get('/hello', function () {
    return 'HELLO';
});

Route::get('/helloo', [CustomerController::class, 'helloo']);


Route::get('/phpinfo', function () {
    ob_start();
    phpinfo();
    $phpinfo = ob_get_clean();
    return response()->make($phpinfo, 200, ['Content-Type' => 'text/html']);
});

Route::post('/customers', [CustomerController::class, 'create']);


