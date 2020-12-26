<?php

namespace App\Src\Tournament\Providers\Services\PlayoffLogic\Instruments;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBProxy as Model;
use App\Src\Tournament\Repositories\PlayoffBracketRepository;
use App\Src\Tournament\Repositories\PlayoffGameRepository;
use App\Src\Tournament\Repositories\PlayoffParticipantRepository;
use App\Src\Tournament\Repositories\PlayoffWinnerRepository;

class DataDBProxyProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Model::class, function ($app) {
            return new Model(
                $app->make(PlayoffBracketRepository::class),
                $app->make(PlayoffParticipantRepository::class),
                $app->make(PlayoffGameRepository::class),
                $app->make(PlayoffWinnerRepository::class),
            );    
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
