<?php

namespace App\Src\Tournament\Services\PlayoffLogic\Instruments;

use App\Src\Tournament\Repositories\PlayoffBracketRepository;
use App\Src\Tournament\Repositories\PlayoffGameRepository;
use App\Src\Tournament\Repositories\PlayoffParticipantRepository;
use App\Src\Tournament\Repositories\PlayoffWinnerRepository;

class DataDBProxy
{
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
     * @return void 
     */
    public function insertBracket(array $bracket)
    {

        $this->playoffBracketRepository->truncate();
        $this->playoffBracketRepository->insert($bracket);
    }

    /**
     * Insert participants
     *     
     * @return void
     */
    public function insertParticipants(array $participants)
    {

        $this->playoffParticipantRepository->truncate();
        $this->playoffParticipantRepository->insert($participants);
    }

    /**
     * Insert games
     * 
     * @return void    
     */
    public function insertGames(array $games)
    {

        $this->playoffGameRepository->truncate();
        $this->playoffGameRepository->insert($games);
    }

    /**
     * Insert winners
     *   
     * @return void  
     */
    public function insertWinners(array $winners)
    {

        $this->playoffWinnerRepository->truncate();
        $this->playoffWinnerRepository->insert($winners);
    }
}
