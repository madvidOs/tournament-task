<?php

namespace App\Providers\Tournament;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Tournament\DivisionRepository;

class DivisionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DivisionRepository::class, function ($app) {
            return new DivisionRepository();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
