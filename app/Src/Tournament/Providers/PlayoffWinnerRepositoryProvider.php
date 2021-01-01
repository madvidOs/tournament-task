<?php

namespace App\Src\Tournament\Providers;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Repositories\PlayoffWinnerRepository as Model;

class PlayoffWinnerRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Model::class, 
            function ($app) {
                return new Model();
            }
        );
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
