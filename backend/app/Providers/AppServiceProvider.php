<?php

namespace App\Providers;

use App\Repositories\Eloquent\ClienteEloquentRepository;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app['request']->server->set('HTTPS', true);
        $this->app->bind(
            ClienteRepositoryInterface::class,
            ClienteEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
