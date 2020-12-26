<?php

namespace App\Src\Tournament\Services;

use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder;

class DivisionsManager {
    
    private InfoBuilder $divisionsInfo;

    public function __construct(        
        InfoBuilder $divisionsInfo           
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