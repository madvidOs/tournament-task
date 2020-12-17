<?php

namespace App\Library\Services\Tournament;

use App\Library\Services\Tournament\PlayoffLogic\PlayoffInfo;

class PlayoffManager {
    
    private PlayoffInfo $playoffInfo;

    public function __construct(        
        PlayoffInfo $playoffInfo           
    ) {        
        $this->playoffInfo = $playoffInfo;
    }    
    

    /**
     * Get playoff games results
     *
     * @return array
     */
    public function getGamesResults() {    
        
        $this->playoffInfo->setUpParticipants();
        $this->playoffInfo->setUpBracket();
        $this->playoffInfo->setUpWinners();
        $this->playoffInfo->setUpTeamsNames();

        $this->playoffInfo->writeDataToDB();

        return $this->playoffInfo->getResponse(['bracket', 'games', 'winners', 'teamNames']);
    }
}