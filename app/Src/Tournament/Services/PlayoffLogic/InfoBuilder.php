<?php

namespace App\Src\Tournament\Services\PlayoffLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoAggregator as DivisionsInfoAggregator;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBPreparation;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\EntitiesGenerator;
use App\Src\Tournament\Services\PlayoffLogic\InfoAggregator;

class InfoBuilder {
    private DivisionsInfoAggregator $divisionsInfoAggregator;
    private DataDBProxy $dataDBProxy;        
    private EntitiesGenerator $entitiesGenerator;
    private DataDBPreparation $dataDBPreparation;
    private InfoAggregator $infoAggregator;    

    public function __construct(
        DivisionsInfoAggregator $divisionsInfoAggregator,
        DataDBProxy $dataDBProxy,
        EntitiesGenerator $entitiesGenerator,
        DataDBPreparation $dataDBPreparation,
        InfoAggregator $infoAggregator
    ) {
        $this->divisionsInfoAggregator = $divisionsInfoAggregator;
        $this->dataDBProxy = $dataDBProxy;
        $this->entitiesGenerator = $entitiesGenerator;        
        $this->dataDBPreparation = $dataDBPreparation;
        $this->infoAggregator = $infoAggregator;
    }

    /**
     * Set up participants
     * 
     * @return void    
     */
    public function setUpParticipants() 
    {
        $divisionPositions 
            = $this->divisionsInfoAggregator->getPositionsInDivisions();        
        $participants 
            = $this->entitiesGenerator->getParticipants($divisionPositions);
        $this->infoAggregator->setParticipants($participants);
    }

    /**
     * Set up bracket
     * 
     * @return void    
     */
    public function setUpBracket() 
    {
        
        $bracket = [];
        $games   = [];        

        //level 1 generation data
        $participants = $this->infoAggregator->getParticipants();
        $bracket[1] = $this->entitiesGenerator->getLevel1Bracket(
            $participants
        );        
        $games[1] = $this->entitiesGenerator->createGamesResults(
            $bracket[1]
        );

        //level 2 generation data (semi-final)
        $bracket[2] = $this->entitiesGenerator->getLevel2Bracket(
            $games[1]
        );
        $games[2] = $this->entitiesGenerator->createGamesResults(
            $bracket[2]
        );

        //level 3 generation data (final)
        $bracket[3] = $this->entitiesGenerator->getLevel3Bracket(
            $games[2]
        );
        $games[3] = $this->entitiesGenerator->createGamesResults(
            $bracket[3]
        ); 
        
        $this->infoAggregator->setBracket($bracket);
        $this->infoAggregator->setGames($games);
    }

    /**
     * Set up winners
     *
     * @return void
     */
    public function setUpWinners() 
    {
        $games = $this->infoAggregator->getWinnersGames();
        $winners = $this->entitiesGenerator->getWinners(
            $games
        );
        $this->infoAggregator->setWinners($winners);

    }

    /**
     * Set up teams names 
     * 
     * @return void   
     */
    public function setUpTeamsNames() 
    {        

        $teams = $this->divisionsInfoAggregator->getAllTeams();  
        $divisions = $this->divisionsInfoAggregator->getDivisions(); 
        $teamsNames = $this->entitiesGenerator->getTeamsNames(
            $divisions, 
            $teams
        );

        $this->infoAggregator->setTeamsNames($teamsNames);        
    }
    
    

    /**
     * Write data to DB    
     * 
     * @return void
     */
    public function writeDataToDB() 
    {
        //participants        
        $participants = $this->infoAggregator->getParticipants();
        $insert = $this->dataDBPreparation->getParticipantsDataForInsert(
            $participants
        );
        $this->dataDBProxy->insertParticipants($insert);        
        
        //bracket
        $bracket = $this->infoAggregator->getBracket();
        $insert = $this->dataDBPreparation->getBracketDataForInsert(
            $bracket
        );
        $this->dataDBProxy->insertBracket($insert);

        //games        
        $games = $this->infoAggregator->getGames();
        $insert = $this->dataDBPreparation->getGamesDataForInsert(
            $games
        );
        $this->dataDBProxy->insertGames($insert);

        //winners
        $winners = $this->infoAggregator->getWinners();
        $insert = $this->dataDBPreparation->getWinnersDataForInsert(
            $winners
        );
        $this->dataDBProxy->insertWinners($insert);
    }

    /**
     * Get result
     *
     * @return InfoAggregator
     */
    public function getInfoAggregator() 
    {        
        return $this->infoAggregator;
    }
}