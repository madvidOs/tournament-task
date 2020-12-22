<?php

namespace App\Library\Services\Tournament\DivisionsLogic;

use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsDataDBProxy;
use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsEntitiesGenerator;
use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsDataDBPreparation;

class DivisionsInfo {

    private DivisionsDataDBProxy $divisionsDataDBProxy;
    private DivisionsEntitiesGenerator $divisionsEntitiesGenerator;
    private DivisionsDataDBPreparation $divisionsDataDBPreparation;

    private $divisions;
    private $allTeams;

    private $teamsByDivision;
    private $gamesByDivision;
    private $scoreByDivision;
    private $positionsByDivision;    

    public function __construct(
        DivisionsDataDBProxy $divisionsDataDBProxy,
        DivisionsEntitiesGenerator $divisionsEntitiesGenerator,
        DivisionsDataDBPreparation $divisionsDataDBPreparation
    ) {
        $this->divisionsDataDBProxy = $divisionsDataDBProxy;
        $this->divisionsEntitiesGenerator = $divisionsEntitiesGenerator;
        $this->divisionsDataDBPreparation = $divisionsDataDBPreparation;
    }

    /**
     * Set Up divisions 
     *
     */
    public function setUpDivisions() {
        $divisions = $this->divisionsDataDBProxy->getDivisions();        
        $result = [];
        
        foreach($divisions as $d) {
            $result[$d->id] = [
                'divisionId' => $d->id,
                'divisionName' => $d->name,
            ];            
        }

        $this->divisions = $result;        
    }

    /**
     * Set Up teams 
     *     
     */
    public function setUpTeams() {
        
        $result = [];
        $teams_ = [];
        $teams = $this->divisionsDataDBProxy->getTeams();

        //var_dump($this->divisionsDataDBProxy);
        
        foreach ($teams as $team) {            
            if (!empty($this->divisions[$team->id_division])) { 
                $result[$team->id_division][$team->id] = [
                    'teamId' => $team->id,
                    'divisionId' => $team->id_division,
                    'teamName' => $team->name,
                ];
                $teams_[$team->id] = [
                    'teamId' => $team->id,
                    'divisionId' => $team->id_division,
                    'teamName' => $team->name,
                ];
            }
        }        
        
        $this->allTeams = $teams_;
        $this->teamsByDivision = $result;
    }

    /**
     * Set Up games 
     *     
     */
    public function setUpGames() {        
        foreach ($this->divisions as $division) {
            $divisionId = $division['divisionId'];            
            $this->gamesByDivision[$divisionId] = 
            $this->divisionsEntitiesGenerator->createGamesResults(
                    $this->teamsByDivision[$divisionId]
            );            
        }
    }

    /**
     * Set Up score
     *     
     */
    public function setUpScore() {        
        foreach ($this->divisions as $division) {
            $divisionId = $division['divisionId'];
            $this->scoreByDivision[$divisionId] = 
            $this->divisionsEntitiesGenerator->countScore(
                    $this->gamesByDivision[$divisionId]
            );
        }        
    }

    /**
     * Set Up positions
     *     
     */
    public function setUpPositions() {
        foreach ($this->divisions as $division) {
            $divisionId = $division['divisionId'];
            $this->positionsByDivision[$divisionId] =
            $this->divisionsEntitiesGenerator->countPositions(
                    $this->scoreByDivision[$divisionId]
            );
        }
    }

    /**
     * Get divisions
     *
     * return array     
     */
    public function getDivisions() {
        return $this->divisions;
    }

    /**
     * Get all teams
     *     
     * return array
     */
    public function getAllTeams() {
        return $this->allTeams;
    }

    /**
     * Get teams By division
     *     
     * return array
     */
    public function getTeamsByDivision() {
        return $this->teamsByDivision;
    }

    /**
     * Get games
     *   
     * return array
     */
    public function getGamesByDivision() {
        return $this->gamesByDivision;
    }


    /**
     * Get score
     *   
     * return array
     */
    public function getScore() {
        return $this->scoreByDivision;
    }


    /**
     * Get positions
     *     
     * return array
     */
    public function getPositions() {
        return $this->positionsByDivision;
    }    
    

    /**
     * write division data to DB
     *     
     */
    public function writeDataToDB() {

        //games        
        $insert = $this->divisionsDataDBPreparation->getGamesDataForInsert(
            $this->gamesByDivision
        );
        $this->divisionsDataDBProxy->insertGames($insert);   

        //positions
        $insert = $this->divisionsDataDBPreparation->getPositionsDataForInsert(
            $this->scoreByDivision, 
            $this->positionsByDivision
        );
        $this->divisionsDataDBProxy->insertPositions($insert);        
    }

    /**
     * Get response
     *
     * @return array
     */
    public function getResponse(array $items) {
        $result = [];

        foreach ($this->divisions as $division) {
            $divisionId = $division['divisionId'];
            $result[$divisionId] = $division;

            if (in_array('teams', $items)) {
                $result[$divisionId]['teams'] = 
                    $this->teamsByDivision[$divisionId];
            }

            if (in_array('games', $items)) {
                $result[$divisionId]['games'] = 
                    $this->gamesByDivision[$divisionId];
            }

            if (in_array('score', $items)) {                
                $result[$divisionId]['score'] = 
                    $this->scoreByDivision[$divisionId];
            }

            if (in_array('positions', $items)) {
                $result[$divisionId]['positions'] = 
                    $this->positionsByDivision[$divisionId];
            }
        }
        
        return ['divisions' => $result];
    }
}