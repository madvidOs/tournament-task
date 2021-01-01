<?php

namespace App\Src\Tournament\Services;

use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder;

class DivisionsManager 
{
    private InfoBuilder $infoBuilder;

    public function __construct(InfoBuilder $infoBuilder) 
    {        
        $this->infoBuilder = $infoBuilder;
    }
    
    
    /**
     * Get divisions with participants
     *
     * @return array
     */
    public function getDivisionsWithParticipants() 
    {

        $this->infoBuilder->setUpDivisions();
        $this->infoBuilder->setUpTeams();  
        
        $infoAggregator = $this->infoBuilder->getInfoAggregator();

        return $infoAggregator->toArray(['teams']);
    }

    /**
     * Get divisions games results
     *
     * @return array
     */
    public function getGamesResults() 
    {
        
        $this->infoBuilder->setUpDivisions();
        $this->infoBuilder->setUpTeams();
        $this->infoBuilder->setUpGames();
        $this->infoBuilder->setUpScore();
        $this->infoBuilder->setUpPositions();        

        $this->infoBuilder->writeDataToDB();

        $infoAggregator = $this->infoBuilder->getInfoAggregator();

        return $infoAggregator->toArray(
            [
                'teams', 
                'games', 
                'score', 
                'positions'
            ]
        );
    }
}