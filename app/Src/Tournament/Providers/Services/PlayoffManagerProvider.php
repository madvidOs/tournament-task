<?php

namespace App\Src\Tournament\Providers\Services;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\PlayoffManager as Model;
use App\Src\Tournament\Services\PlayoffLogic\InfoBuilder;

class PlayoffManagerProvider extends ServiceProvider
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
                return new Model(
                    $app->make(InfoBuilder::class)
                );
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
