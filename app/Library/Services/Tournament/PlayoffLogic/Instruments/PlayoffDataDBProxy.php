<?php

namespace App\Library\Services\Tournament\PlayoffLogic\Instruments;

use App\Repositories\Tournament\PlayoffBracketRepository;
use App\Repositories\Tournament\PlayoffGameRepository;
use App\Repositories\Tournament\PlayoffParticipantRepository;
use App\Repositories\Tournament\PlayoffWinnerRepository;

class PlayoffDataDBProxy {
    
    /**
     * Insert bracket
     *     
     */
    public function insertBracket(array $bracket) {        

        PlayoffBracketRepository::truncate();
        PlayoffBracketRepository::insert($bracket);
        
    }    

    /**
     * Insert participants
     *     
     */
    public function insertParticipants(array $participants) {        

        PlayoffParticipantRepository::truncate();
        PlayoffParticipantRepository::insert($participants);
        
    }    

    /**
     * Insert games
     *     
     */
    public function insertGames(array $games) {        

        PlayoffGameRepository::truncate();
        PlayoffGameRepository::insert($games);
        
    }

    /**
     * Insert winners
     *     
     */
    public function insertWinners(array $winners) {

        PlayoffWinnerRepository::truncate();
        PlayoffWinnerRepository::insert($winners);
        
    }
    
}