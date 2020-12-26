<?php

namespace App\Src\Tournament\Services\PlayoffLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder as DivisionsInfoBuilder;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBPreparation;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\EntitiesGenerator;

class InfoBuilder {
    private DivisionsInfoBuilder $divisionsInfoBuilder;
    private DataDBProxy $playoffDataDBProxy;        
    private EntitiesGenerator $entitiesGenerator;
    private DataDBPreparation $dataDBPreparation;

    private $participants;    
    private $bracket;
    private $games;
    private $winners;
    private $teamsNames;


    public function __construct(
        DivisionsInfoBuilder $divisionsInfoBuilder,
        DataDBProxy $playoffDataDBProxy,
        EntitiesGenerator $entitiesGenerator,
        DataDBPreparation $dataDBPreparation
    ) {
        $this->divisionsInfoBuilder = $divisionsInfoBuilder;
        $this->playoffDataDBProxy = $playoffDataDBProxy;
        $this->entitiesGenerator = $entitiesGenerator;        
        $this->dataDBPreparation = $dataDBPreparation;
    }

    /**
     * Set up participants
     *     
     */
    public function setUpParticipants() {
        $divisionPositions = $this->divisionsInfoBuilder->getPositions();        
        $this->participants = $this->entitiesGenerator
            ->getParticipants($divisionPositions);        
    }

    /**
     * Set up bracket
     *     
     */
    public function setUpBracket() {
        
        $bracket = [];
        $games   = [];        

        //level 1 generation data
        $bracket[1] = $this->entitiesGenerator->getLevel1Bracket(
            $this->participants
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

        $this->bracket = $bracket;
        $this->games   = $games;
    }

    /**
     * set up winners
     *
     */
    public function setUpWinners() {
        $this->winners = $this->entitiesGenerator->getWinners(
            $this->games[3]
        );        
    }

    /**
     * set up teams names
     *     
     */
    public function setUpTeamsNames() {        

        $teams = $this->divisionsInfoBuilder->getAllTeams();  
        $divisions = $this->divisionsInfoBuilder->getDivisions(); 
        $teamsNames = $this->entitiesGenerator->getTeamsNames(
            $divisions, 
            $teams
        );
        
        $this->teamsNames = $teamsNames;
    }
    
    

    /**
     * write data to DB
     *     
     */
    public function writeDataToDB() {
        //participants        
        $insert = $this->dataDBPreparation->getParticipantsDataForInsert(
            $this->participants
        );
        $this->playoffDataDBProxy->insertParticipants($insert);        
        
        //bracket
        $insert = $this->dataDBPreparation->getBracketDataForInsert(
            $this->bracket
        );
        $this->playoffDataDBProxy->insertBracket($insert);

        //games        
        $insert = $this->dataDBPreparation->getGamesDataForInsert(
            $this->games
        );
        $this->playoffDataDBProxy->insertGames($insert);

        //winners
        $insert = $this->dataDBPreparation->getWinnersDataForInsert(
            $this->winners
        );
        $this->playoffDataDBProxy->insertWinners($insert);
    }

    /**
     * Get response
     *
     * @return array
     */
    public function getResponse(array $items) {
        
        $result = [];

        if (in_array('bracket', $items)) {
            $result['bracket'] = $this->bracket;
        }

        if (in_array('games', $items)) {
            $result['games'] = $this->games;
        }

        if (in_array('winners', $items)) {
            $result['winners'] = $this->winners;
        }        

        if (in_array('teamNames', $items)) {
            $result['teamNames'] = $this->teamsNames;
        }        

        return ['playoff' => $result];
    }
}