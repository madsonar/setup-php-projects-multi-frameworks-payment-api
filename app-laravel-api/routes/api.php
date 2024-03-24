<?php

use Illuminate\Support\Facades\Route;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Http\Controllers\CustomerController;

Route::post('/customers', [CustomerController::class, 'create']);
