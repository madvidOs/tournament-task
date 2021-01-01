<?php

namespace App\Src\Tournament\Providers\Services;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\DivisionsManager as Model;
use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder;

class DivisionsManagerProvider extends ServiceProvider
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
