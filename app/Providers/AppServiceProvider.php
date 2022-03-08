<?php

namespace App\Providers;

use App\Repositories\TodoRepository;
use App\Interfaces\TodoRepositoryInterface;
use App\Repositories\AssignerRepository;
use App\Interfaces\AssignerRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
        $this->app->bind(AssignerRepositoryInterface::class, AssignerRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
