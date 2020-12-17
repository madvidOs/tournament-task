<?php

namespace App\Library\Services\Tournament\PlayoffLogic;

use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBPreparation;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBProxy;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffEntitiesGenerator;

class PlayoffInfo {
    private DivisionsInfo $divisionsInfo;
    private PlayoffDataDBProxy $playoffDataDBProxy;        

    private $participants;    
    private $bracket;
    private $games;
    private $winners;
    private $teamsNames;


    public function __construct(
        DivisionsInfo $divisionsInfo,
        PlayoffDataDBProxy $playoffDataDBProxy
    ) {
        $this->divisionsInfo = $divisionsInfo;
        $this->playoffDataDBProxy = $playoffDataDBProxy;        
    }

    /**
     * set up participants
     *
     * @return array
     */
    public function setUpParticipants() {
        $divisionPositions = $this->divisionsInfo->getPositions();        
        $this->participants = PlayoffEntitiesGenerator::getParticipants($divisionPositions);        
    }

    /**
     * set up bracket
     *
     * @return array
     */
    public function setUpBracket() {        
        
        $bracket = [];
        $games   = [];        

        $bracket[1] = PlayoffEntitiesGenerator::getLevel1Bracket($this->participants);        
        $games[1] = PlayoffEntitiesGenerator::createGamesResults($bracket[1]);

        $bracket[2] = PlayoffEntitiesGenerator::getLevel2Bracket($games[1]);
        $games[2] = PlayoffEntitiesGenerator::createGamesResults($bracket[2]);

        $bracket[3] = PlayoffEntitiesGenerator::getLevel3Bracket($games[2]);
        $games[3] = PlayoffEntitiesGenerator::createGamesResults($bracket[3]);        

        $this->bracket = $bracket;
        $this->games   = $games;
    }

    /**
     * set up winners
     *
     * @return array
     */
    public function setUpWinners() {
        $this->winners = PlayoffEntitiesGenerator::getWinners($this->games[3]);        
    }

    /**
     * set up teams names
     *
     * @return array
     */
    public function setUpTeamsNames() {        

        $teams = $this->divisionsInfo->getAllTeams();  
        $divisions = $this->divisionsInfo->getDivisions(); 
        $teamsNames = PlayoffEntitiesGenerator::getTeamsNames($divisions, $teams);
        
        $this->teamsNames = $teamsNames;
    }
    
    

    /**
     * write data to DB
     *     
     */
    public function writeDataToDB() {
        //participants        
        $insert = PlayoffDataDBPreparation::getParticipantsDataForInsert($this->participants);
        $this->playoffDataDBProxy->insertParticipants($insert);        
        
        //bracket
        $insert = PlayoffDataDBPreparation::getBracketDataForInsert($this->bracket);
        $this->playoffDataDBProxy->insertBracket($insert);

        //games        
        $insert = PlayoffDataDBPreparation::getGamesDataForInsert($this->games);
        $this->playoffDataDBProxy->insertGames($insert);

        //winners
        $insert = PlayoffDataDBPreparation::getWinnersDataForInsert($this->winners);
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