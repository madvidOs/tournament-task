<?php

namespace App\Src\Tournament\Services\DivisionsLogic;

class InfoAggregator {    

    private $divisions;
    private $allTeams;

    private $teamsByDivision;
    private $gamesByDivision;
    private $scoreByDivision;
    private $positionsByDivision;    

    public function __construct() {        
    }

    /**
     * Set divisions 
     *
     */
    public function setDivisions(array $srcDivisions) {        
        $result = [];
        
        foreach($srcDivisions as $d) {
            $result[$d->id] = [
                'divisionId' => $d->id,
                'divisionName' => $d->name,
            ];            
        }

        $this->divisions = $result;        
    }

    /**
     * Set teams 
     *     
     */
    public function setTeams(array $srcTeams) {        
        $result = [];
        $teams_ = [];                
        
        foreach ($srcTeams as $team) {            
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
     * Set games 
     *     
     */
    public function setGamesByDivisionId($divisionId, $games) {        
        $this->gamesByDivision[$divisionId] = $games;        
    }

    /**
     * Set score
     *     
     */
    public function setScoreByDivisionId($divisionId, $score) {        
        $this->scoreByDivision[$divisionId] = $score;
    }

    /**
     * Set positions
     *     
     */
    public function setPositionsByDivisionId($divisionId, $positions) {
        $this->positionsByDivision[$divisionId] = $positions;        
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
     * Get teams by division id
     *     
     * return array
     */
    public function getTeamsByDivisionId($divisionId) {
        return $this->teamsByDivision[$divisionId];
    }

    /**
     * Get teams in divisions
     *     
     * return array
     */
    public function getTeamsInDivisions() {
        return $this->teamsByDivision;
    }

    /**
     * Get games by division id
     *   
     * return array
     */
    public function getGamesByDivisionId($divisionId) {
        return $this->gamesByDivision[$divisionId];
    }

    /**
     * Get games in divisions
     *   
     * return array
     */
    public function getGamesInDivisions() {
        return $this->gamesByDivision;
    }


    /**
     * Get score by division id
     *   
     * return array
     */
    public function getScoreByDivisionId($divisionId) {
        return $this->scoreByDivision[$divisionId];
    }

    /**
     * Get score in divisions
     *   
     * return array
     */
    public function getScoreInDivisions() {        
        return $this->scoreByDivision; 
    }


    /**
     * Get positions
     *     
     * return array
     */
    public function getPositionsByDivisionId($divisionId) {
        return $this->positionsByDivision[$divisionId];
    }

    /**
     * Get positions in divisions
     *     
     * return array
     */
    public function getPositionsInDivisions() {
        return $this->positionsByDivision;
    }    

    /**
     * Get response
     *
     * @return array
     */
    public function toArray(array $items) {
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