<?php

namespace App\Src\Tournament\Services\DivisionsLogic;

use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\EntitiesGenerator;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBPreparation;

class InfoBuilder {

    private DataDBProxy $dataDBProxy;
    private EntitiesGenerator $entitiesGenerator;
    private DataDBPreparation $dataDBPreparation;
    private InfoAggregator $infoAggregator;    
    

    public function __construct(
        DataDBProxy $dataDBProxy,
        EntitiesGenerator $entitiesGenerator,
        DataDBPreparation $dataDBPreparation,
        InfoAggregator $infoAggregator
    ) {
        $this->dataDBProxy = $dataDBProxy;
        $this->entitiesGenerator = $entitiesGenerator;
        $this->dataDBPreparation = $dataDBPreparation;
        $this->infoAggregator = $infoAggregator;
    }

    /**
     * Set Up divisions 
     *
     */
    public function setUpDivisions() {
        $divisions = $this->dataDBProxy->getDivisions();        
        $this->infoAggregator->setDivisions($divisions->all());       
    }

    /**
     * Set Up teams 
     *     
     */
    public function setUpTeams() {

        $teams = $this->dataDBProxy->getTeams();
        $this->infoAggregator->setTeams($teams->all());        
    }

    /**
     * Set Up games 
     *     
     */
    public function setUpGames() {
        foreach ($this->infoAggregator->getDivisions() as $division) {
            $divisionId = $division['divisionId'];   
            $teams = $this->infoAggregator->getTeamsByDivisionId($divisionId); 
            $games = $this->entitiesGenerator->createGamesResults($teams);            
            $this->infoAggregator->setGamesByDivisionId($divisionId, $games);            
        }
    }

    /**
     * Set Up score
     *     
     */
    public function setUpScore() {        
        foreach ($this->infoAggregator->getDivisions() as $division) {
            $divisionId = $division['divisionId'];
            $games = $this->infoAggregator->getGamesByDivisionId($divisionId);
            $score = $this->entitiesGenerator->countScore($games);           
            $this->infoAggregator->setScoreByDivisionId($divisionId, $score);
        }        
    }

    /**
     * Set Up positions
     *     
     */
    public function setUpPositions() {
        foreach ($this->infoAggregator->getDivisions() as $division) {
            $divisionId = $division['divisionId'];
            $score = $this->infoAggregator->getScoreByDivisionId($divisionId);
            $positions = $this->entitiesGenerator->countPositions($score);
            $this->infoAggregator->setPositionsByDivisionId($divisionId, $positions);            
        }
    }    

    /**
     * write division data to DB
     *     
     */
    public function writeDataToDB() {

        //games 
        $games = $this->infoAggregator->getGamesInDivisions();       
        $insert = $this->dataDBPreparation->getGamesDataForInsert($games);
        $this->dataDBProxy->insertGames($insert);   

        //positions
        $score = $this->infoAggregator->getScoreInDivisions();
        $positions = $this->infoAggregator->getPositionsInDivisions();
        $insert = $this->dataDBPreparation->getPositionsDataForInsert(
            $score, 
            $positions
        );
        $this->dataDBProxy->insertPositions($insert);        
    }

    /**
     * Get response
     *
     * @return InfoAggregator
     */
    public function getInfoAggregator() {
        return $this->infoAggregator;
    }
}