<?php

namespace App\Src\Tournament\Services;

use App\Src\Tournament\Services\PlayoffLogic\InfoBuilder;

class PlayoffManager {
    
    private InfoBuilder $infoBuilder;

    public function __construct(        
        InfoBuilder $infoBuilder           
    ) {        
        $this->infoBuilder = $infoBuilder;
    }    
    

    /**
     * Get playoff games results
     *
     * @return array
     */
    public function getGamesResults() 
    {    
        
        $this->infoBuilder->setUpParticipants();
        $this->infoBuilder->setUpBracket();
        $this->infoBuilder->setUpWinners();
        $this->infoBuilder->setUpTeamsNames();

        $this->infoBuilder->writeDataToDB();

        $infoAggregator = $this->infoBuilder->getInfoAggregator();

        return $infoAggregator->toArray(
            [
                'bracket', 
                'games', 
                'winners', 
                'teamsNames'
            ]
        );
    }
}