<?php

namespace App\Providers;

use App\Repositories\SupplyRepository;
use App\Services\SupplyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SupplyRepository::class, function ($app) {
            return new SupplyRepository();
        });

        $this->app->bind(SupplyService::class, function ($app) {
            return new SupplyService($app->make(SupplyRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
