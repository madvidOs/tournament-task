<?php

namespace App\Src\Tournament\Providers\Services\PlayoffLogic;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\PlayoffLogic\InfoAggregator as Model;

class InfoAggregatorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
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
