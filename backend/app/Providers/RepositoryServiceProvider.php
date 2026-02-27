<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SupplierRepositoryInterface;
use App\Repositories\SupplierRepository;
use App\Repositories\SupplierTypeRepositoryInterface;
use App\Repositories\SupplierTypeRepository;
use App\Repositories\SupplierStatusRepositoryInterface;
use App\Repositories\SupplierStatusRepository;
use App\Repositories\CurrencyRepositoryInterface;
use App\Repositories\CurrencyRepository;
use App\Repositories\PaymentTermRepositoryInterface;
use App\Repositories\PaymentTermRepository;
use App\Repositories\SupplierContactRepositoryInterface;
use App\Repositories\SupplierContactRepository;
use App\Repositories\MaterialRepositoryInterface;
use App\Repositories\MaterialRepository;

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
            SupplierTypeRepositoryInterface::class,
            SupplierTypeRepository::class
        );

        $this->app->bind(
            SupplierStatusRepositoryInterface::class,
            SupplierStatusRepository::class
        );

        $this->app->bind(
            CurrencyRepositoryInterface::class,
            CurrencyRepository::class
        );

        $this->app->bind(
            PaymentTermRepositoryInterface::class,
            PaymentTermRepository::class
        );

        $this->app->bind(
            SupplierContactRepositoryInterface::class,
            SupplierContactRepository::class
        );

        $this->app->bind(
            MaterialRepositoryInterface::class,
            MaterialRepository::class
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
