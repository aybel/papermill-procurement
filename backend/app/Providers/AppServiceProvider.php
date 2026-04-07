<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\Contracts\EmailServiceInterface::class, \App\Services\Implementations\LaravelMailService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar Carbon para usar español
        Carbon::setLocale('es');

        // Configurar el locale del sistema para fechas
        setlocale(LC_TIME, 'es_MX.UTF-8', 'es_MX', 'es_ES', 'es', 'spanish');
    }
}
