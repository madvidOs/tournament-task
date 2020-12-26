<?php

namespace App\Src\Tournament\Services\DivisionsLogic;

use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\EntitiesGenerator;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBPreparation;

class InfoBuilder {

    private DataDBProxy $dataDBProxy;
    private EntitiesGenerator $entitiesGenerator;
    private DataDBPreparation $dataDBPreparation;

    private $divisions;
    private $allTeams;

    private $teamsByDivision;
    private $gamesByDivision;
    private $scoreByDivision;
    private $positionsByDivision;    

    public function __construct(
        DataDBProxy $dataDBProxy,
        EntitiesGenerator $entitiesGenerator,
        DataDBPreparation $dataDBPreparation
    ) {
        $this->dataDBProxy = $dataDBProxy;
        $this->entitiesGenerator = $entitiesGenerator;
        $this->dataDBPreparation = $dataDBPreparation;
    }

    /**
     * Set Up divisions 
     *
     */
    public function setUpDivisions() {
        $divisions = $this->dataDBProxy->getDivisions();        
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
        $teams = $this->dataDBProxy->getTeams();

        //var_dump($this->dataDBProxy);
        
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
            $this->entitiesGenerator->createGamesResults(
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
            $this->entitiesGenerator->countScore(
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
            $this->entitiesGenerator->countPositions(
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
        $insert = $this->dataDBPreparation->getGamesDataForInsert(
            $this->gamesByDivision
        );
        $this->dataDBProxy->insertGames($insert);   

        //positions
        $insert = $this->dataDBPreparation->getPositionsDataForInsert(
            $this->scoreByDivision, 
            $this->positionsByDivision
        );
        $this->dataDBProxy->insertPositions($insert);        
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