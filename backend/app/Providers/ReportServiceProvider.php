<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Reports\ReportService;
use App\Services\Reports\SuppliersReportGenerator;
use App\Repositories\SupplierRepositoryInterface;

class ReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ReportService::class, function ($app) {
            $service = new ReportService();
            // Registrar generadores de reportes aquí
            $service->registerGenerator('suppliers', new SuppliersReportGenerator($app->make(SupplierRepositoryInterface::class)));
            // Puedes registrar más generadores aquí
            return $service;
        });
    }
}
