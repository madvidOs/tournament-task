<?php

namespace App\Providers\Tournament\Library\PlayoffLogic\Instruments;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBProxy as Model;
use App\Repositories\Tournament\PlayoffBracketRepository;
use App\Repositories\Tournament\PlayoffGameRepository;
use App\Repositories\Tournament\PlayoffParticipantRepository;
use App\Repositories\Tournament\PlayoffWinnerRepository;

class PlayoffDataDBProxyProvider extends ServiceProvider
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
