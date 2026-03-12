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
use App\Repositories\MaterialTypeRepositoryInterface;
use App\Repositories\MaterialTypeRepository;
use App\Repositories\MaterialCategoryRepositoryInterface;
use App\Repositories\MaterialCategoryRepository;
use App\Repositories\UnitOfMeasureRepositoryInterface;
use App\Repositories\UnitOfMeasureRepository;
use App\Repositories\BudgetAssignmentRepositoryInterface;
use App\Repositories\BudgetAssignmentRepository;
use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\BudgetRequestStatusRepositoryInterface;
use App\Repositories\BudgetRequestStatusRepository;
use App\Repositories\BudgetRequestRepositoryInterface;
use App\Repositories\BudgetRequestRepository;
use App\Repositories\BudgetRequestItemRepositoryInterface;
use App\Repositories\BudgetRequestItemRepository;
use App\Repositories\BudgetCategoryRepositoryInterface;
use App\Repositories\BudgetCategoryRepository;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\MenuRepository;

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

        $this->app->bind(
            MaterialTypeRepositoryInterface::class,
            MaterialTypeRepository::class
        );

        $this->app->bind(
            MaterialCategoryRepositoryInterface::class,
            MaterialCategoryRepository::class
        );

        $this->app->bind(
            UnitOfMeasureRepositoryInterface::class,
            UnitOfMeasureRepository::class
        );

        $this->app->bind(
            BudgetAssignmentRepositoryInterface::class,
            BudgetAssignmentRepository::class
        );

        $this->app->bind(
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        );

        $this->app->bind(
            BudgetRequestStatusRepositoryInterface::class,
            BudgetRequestStatusRepository::class
        );

        $this->app->bind(
            BudgetRequestRepositoryInterface::class,
            BudgetRequestRepository::class
        );

        $this->app->bind(
            BudgetRequestItemRepositoryInterface::class,
            BudgetRequestItemRepository::class
        );

        $this->app->bind(
            BudgetCategoryRepositoryInterface::class,
            BudgetCategoryRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->bind(
            MenuRepositoryInterface::class,
            MenuRepository::class
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
