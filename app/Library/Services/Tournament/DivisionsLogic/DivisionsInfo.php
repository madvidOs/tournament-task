<?php

namespace App\Library\Services\Tournament\DivisionsLogic;

use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsDataDBProxy;
use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsEntitiesGenerator;
use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsDataDBPreparation;

class DivisionsInfo {

    private DivisionsDataDBProxy $divisionsDataDBProxy;

    private $divisions;
    private $allTeams;

    private $teamsByDivision;
    private $gamesByDivision;
    private $scoreByDivision;
    private $positionsByDivision;    

    public function __construct(
        DivisionsDataDBProxy $divisionsDataDBProxy
    ) {
        $this->divisionsDataDBProxy = $divisionsDataDBProxy;
    }

    /**
     * Set Up divisions 
     *
     * @return array
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
            $this->gamesByDivision[$division['divisionId']] = DivisionsEntitiesGenerator::createGamesResults($this->teamsByDivision[$division['divisionId']]);
        }
    }

    /**
     * Set Up score
     *     
     */
    public function setUpScore() {        
        foreach ($this->divisions as $division) {
            $this->scoreByDivision[$division['divisionId']] = DivisionsEntitiesGenerator::countScore($this->gamesByDivision[$division['divisionId']]);
        }        
    }

    /**
     * Set Up positions
     *     
     */
    public function setUpPositions() {
        foreach ($this->divisions as $division) {
            $this->positionsByDivision[$division['divisionId']] = DivisionsEntitiesGenerator::countPositions($this->scoreByDivision[$division['divisionId']]);
        }
    }

    /**
     * Get divisions
     *     
     */
    public function getDivisions() {
        return $this->divisions;
    }

    /**
     * Get all teams
     *     
     */
    public function getAllTeams() {
        return $this->allTeams;
    }


    /**
     * Get score
     *     
     */
    public function getScore() {
        return $this->scoreByDivision;
    }


    /**
     * Get positions
     *     
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
        $insert = DivisionsDataDBPreparation::getGamesDataForInsert($this->gamesByDivision);
        $this->divisionsDataDBProxy->insertGames($insert);   

        //positions
        $insert = DivisionsDataDBPreparation::getPositionsDataForInsert($this->scoreByDivision, $this->positionsByDivision);
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
            $result['divisions'][$division['divisionId']] = $division;

            if (in_array('teams', $items)) {
                $result['divisions'][$division['divisionId']]['teams'] =
                    $this->teamsByDivision[$division['divisionId']];
            }

            if (in_array('games', $items)) {
                $result['divisions'][$division['divisionId']]['games'] =
                    $this->gamesByDivision[$division['divisionId']];
            }

            if (in_array('score', $items)) {                
                $result['divisions'][$division['divisionId']]['score'] =
                    $this->scoreByDivision[$division['divisionId']];
            }

            if (in_array('positions', $items)) {
                $result['divisions'][$division['divisionId']]['positions'] =
                    $this->positionsByDivision[$division['divisionId']];
            }
        }
        return $result;
    }
}