<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SupplierRepositoryInterface;
use App\Repositories\SupplierRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            SupplierRepositoryInterface::class,
            SupplierRepository::class
        );
        $this->app->bind(
            \App\Repositories\CurrencyRepositoryInterface::class,
            \App\Repositories\CurrencyRepository::class
        );
        $this->app->bind(
            \App\Repositories\PaymentTermRepositoryInterface::class,
            \App\Repositories\PaymentTermRepository::class
        );
        $this->app->bind(
            \App\Repositories\SupplierContactRepositoryInterface::class,
            \App\Repositories\SupplierContactRepository::class
        );
        $this->app->bind(
            \App\Repositories\SupplierStatusRepositoryInterface::class,
            \App\Repositories\SupplierStatusRepository::class
        );
        $this->app->bind(
            \App\Repositories\SupplierTypeRepositoryInterface::class,
            \App\Repositories\SupplierTypeRepository::class
        );
        $this->app->bind(
            \App\Repositories\MaterialRepositoryInterface::class,
            \App\Repositories\MaterialRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
