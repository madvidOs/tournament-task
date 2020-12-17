<?php

namespace App\Library\Services\Tournament\DivisionsLogic\Instruments;

use App\Repositories\Tournament\DivisionGameRepository;
use App\Repositories\Tournament\DivisionPositionRepository;
use App\Repositories\Tournament\DivisionRepository;
use App\Repositories\Tournament\DivisionTeamRepository;

class DivisionsDataDBProxy {

    private DivisionRepository $divisionRepository;
    private DivisionTeamRepository $divisionTeamRepository;

    public function __construct(        
            DivisionRepository $divisionRepository,
            DivisionTeamRepository $divisionTeamRepository        
    ) {
        $this->divisionRepository = $divisionRepository;
        $this->divisionTeamRepository = $divisionTeamRepository;
    }

    /**
     * Get divisions 
     *
     * @return Collection
     */
    public function getDivisions() {        
        return $this->divisionRepository->all();
    }

    /**
     * Get divisions 
     *
     * @return Collection
     */
    public function getTeams() {        
        return $this->divisionTeamRepository->all();
    }   

    /**
     * Insert games
     *     
     */
    public function insertGames(array $games) {

        DivisionGameRepository::truncate();
        DivisionGameRepository::insert($games);
        
    }

    /**
     * Insert positions
     *     
     */
    public function insertPositions(array $positions) {

        DivisionPositionRepository::truncate();
        DivisionPositionRepository::insert($positions);        
    }
    
}