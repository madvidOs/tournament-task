<?php

namespace App\Src\Tournament\Providers\Services\PlayoffLogic\Instruments;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBPreparation as Model;

class DataDBPreparationProvider extends ServiceProvider
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
