<?php

namespace App\Library\Services\Tournament;

use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo;

class DivisionsManager {
    
    private DivisionsInfo $divisionsInfo;

    public function __construct(        
        DivisionsInfo $divisionsInfo           
    ) {        
        $this->divisionsInfo = $divisionsInfo;
    }
    
    
    /**
     * Get divisions with participants
     *
     * @return array
     */
    public function getDivisionsWithParticipants() {

        $this->divisionsInfo->setUpDivisions();
        $this->divisionsInfo->setUpTeams();        

        return $this->divisionsInfo->getResponse(['teams']);
    }

    /**
     * Get divisions games results
     *
     * @return array
     */
    public function getGamesResults() {    
        
        $this->divisionsInfo->setUpDivisions();
        $this->divisionsInfo->setUpTeams();
        $this->divisionsInfo->setUpGames();
        $this->divisionsInfo->setUpScore();
        $this->divisionsInfo->setUpPositions();        

        $this->divisionsInfo->writeDataToDB();

        return $this->divisionsInfo->getResponse(['teams', 'games', 'score', 'positions']);
    }
}