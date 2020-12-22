<?php

namespace App\Library\Services\Tournament\PlayoffLogic\Instruments;

use App\Repositories\Tournament\PlayoffBracketRepository;
use App\Repositories\Tournament\PlayoffGameRepository;
use App\Repositories\Tournament\PlayoffParticipantRepository;
use App\Repositories\Tournament\PlayoffWinnerRepository;

class PlayoffDataDBProxy {
    private PlayoffBracketRepository $playoffBracketRepository;
    private PlayoffParticipantRepository $playoffParticipantRepository;
    private PlayoffGameRepository $playoffGameRepository;
    private PlayoffWinnerRepository $playoffWinnerRepository;

    public function __construct(
        PlayoffBracketRepository $playoffBracketRepository,
        PlayoffParticipantRepository $playoffParticipantRepository,
        PlayoffGameRepository $playoffGameRepository,
        PlayoffWinnerRepository $playoffWinnerRepository
    ) {
        $this->playoffBracketRepository = $playoffBracketRepository;
        $this->playoffParticipantRepository = $playoffParticipantRepository;
        $this->playoffGameRepository = $playoffGameRepository;
        $this->playoffWinnerRepository = $playoffWinnerRepository;

    }

    
    /**
     * Insert bracket
     *     
     */
    public function insertBracket(array $bracket) {        

        $this->playoffBracketRepository->truncate();
        $this->playoffBracketRepository->insert($bracket);        
        
    }    

    /**
     * Insert participants
     *     
     */
    public function insertParticipants(array $participants) {        

        $this->playoffParticipantRepository->truncate();
        $this->playoffParticipantRepository->insert($participants);        
        
    }    

    /**
     * Insert games
     *     
     */
    public function insertGames(array $games) {        

        $this->playoffGameRepository->truncate();
        $this->playoffGameRepository->insert($games);        
        
    }

    /**
     * Insert winners
     *     
     */
    public function insertWinners(array $winners) {

        $this->playoffWinnerRepository->truncate();
        $this->playoffWinnerRepository->insert($winners);        
    }
    
}