<?php

namespace App\Library\Services\Tournament\PlayoffLogic;

use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBPreparation;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBProxy;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffEntitiesGenerator;

class PlayoffInfo {
    private DivisionsInfo $divisionsInfo;
    private PlayoffDataDBProxy $playoffDataDBProxy;        
    private PlayoffEntitiesGenerator $playoffEntitiesGenerator;
    private PlayoffDataDBPreparation $playoffDataDBPreparation;

    private $participants;    
    private $bracket;
    private $games;
    private $winners;
    private $teamsNames;


    public function __construct(
        DivisionsInfo $divisionsInfo,
        PlayoffDataDBProxy $playoffDataDBProxy,
        PlayoffEntitiesGenerator $playoffEntitiesGenerator,
        PlayoffDataDBPreparation $playoffDataDBPreparation
    ) {
        $this->divisionsInfo = $divisionsInfo;
        $this->playoffDataDBProxy = $playoffDataDBProxy;
        $this->playoffEntitiesGenerator = $playoffEntitiesGenerator;        
        $this->playoffDataDBPreparation = $playoffDataDBPreparation;
    }

    /**
     * Set up participants
     *     
     */
    public function setUpParticipants() {
        $divisionPositions = $this->divisionsInfo->getPositions();        
        $this->participants = $this->playoffEntitiesGenerator
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
        $bracket[1] = $this->playoffEntitiesGenerator->getLevel1Bracket(
            $this->participants
        );        
        $games[1] = $this->playoffEntitiesGenerator->createGamesResults(
            $bracket[1]
        );

        //level 2 generation data (semi-final)
        $bracket[2] = $this->playoffEntitiesGenerator->getLevel2Bracket(
            $games[1]
        );
        $games[2] = $this->playoffEntitiesGenerator->createGamesResults(
            $bracket[2]
        );

        //level 3 generation data (final)
        $bracket[3] = $this->playoffEntitiesGenerator->getLevel3Bracket(
            $games[2]
        );
        $games[3] = $this->playoffEntitiesGenerator->createGamesResults(
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
        $this->winners = $this->playoffEntitiesGenerator->getWinners(
            $this->games[3]
        );        
    }

    /**
     * set up teams names
     *     
     */
    public function setUpTeamsNames() {        

        $teams = $this->divisionsInfo->getAllTeams();  
        $divisions = $this->divisionsInfo->getDivisions(); 
        $teamsNames = $this->playoffEntitiesGenerator->getTeamsNames(
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
        $insert = $this->playoffDataDBPreparation->getParticipantsDataForInsert(
            $this->participants
        );
        $this->playoffDataDBProxy->insertParticipants($insert);        
        
        //bracket
        $insert = $this->playoffDataDBPreparation->getBracketDataForInsert(
            $this->bracket
        );
        $this->playoffDataDBProxy->insertBracket($insert);

        //games        
        $insert = $this->playoffDataDBPreparation->getGamesDataForInsert(
            $this->games
        );
        $this->playoffDataDBProxy->insertGames($insert);

        //winners
        $insert = $this->playoffDataDBPreparation->getWinnersDataForInsert(
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