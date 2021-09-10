<?php

namespace App\Providers;

use App\Services\Api\ManagerService;
use App\Services\Api\OrganizationService;
use App\Services\Api\PersonService;
use App\Services\Impl\ManagerServiceImpl;
use App\Services\Impl\OrganizationServiceImpl;
use App\Services\Impl\PersonServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrganizationService::class, OrganizationServiceImpl::class);
        $this->app->bind(ManagerService::class, ManagerServiceImpl::class);
        $this->app->bind(PersonService::class, PersonServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
