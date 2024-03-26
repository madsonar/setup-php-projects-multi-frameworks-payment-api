<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\CustomerRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\WalletRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Customer\Repositories\CustomerRepository;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Domain\Repositories\TransactionRepositoryContract;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Repositories\TransactionRepository;
use App\Architecture\CoreDomain\BoundedContexts\Payment\Infrastructure\Payment\Repositories\WalletRepository;
use App\Architecture\Shared\Domain\Contracts\HttpClient\HttpClientContract;
use App\Architecture\Shared\Infrastructure\Adapters\Http\Client\Laravel\HttpClientLaravel;
use Illuminate\Support\Facades\Http;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryContract::class, CustomerRepository::class);
        $this->app->bind(TransactionRepositoryContract::class, TransactionRepository::class);
        $this->app->bind(WalletRepositoryContract::class, WalletRepository::class);
        $this->app->bind(HttpClientContract::class, HttpClientLaravel::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->setBootstrapHttpClientToExternalPaymentAuthorizerService();
    }

    private function setBootstrapHttpClientToExternalPaymentAuthorizerService()
    {
        Http::macro('externalPaymentAuthorizerApi', function () {
            $headers = [
                'Accept' => 'application/json',
            ];
            return Http::withHeaders($headers)->baseUrl(env('API_EXTERNAL_PAYMENT_AUTHORIZER_BASE_URL'));
        });
    }
}
