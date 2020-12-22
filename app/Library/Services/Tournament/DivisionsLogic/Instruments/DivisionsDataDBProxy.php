<?php

namespace App\Library\Services\Tournament\DivisionsLogic\Instruments;

use App\Repositories\Tournament\DivisionGameRepository;
use App\Repositories\Tournament\DivisionPositionRepository;
use App\Repositories\Tournament\DivisionRepository;
use App\Repositories\Tournament\DivisionTeamRepository;

class DivisionsDataDBProxy {

    private DivisionRepository $divisionRepository;
    private DivisionTeamRepository $divisionTeamRepository;
    private DivisionGameRepository $divisionGameRepository;
    private DivisionPositionRepository $divisionPositionRepository;

    public function __construct(
            DivisionRepository $divisionRepository,
            DivisionTeamRepository $divisionTeamRepository,
            DivisionGameRepository $divisionGameRepository,
            DivisionPositionRepository $divisionPositionRepository        
    ) {
        $this->divisionRepository = $divisionRepository;
        $this->divisionTeamRepository = $divisionTeamRepository;
        $this->divisionGameRepository = $divisionGameRepository;
        $this->divisionPositionRepository = $divisionPositionRepository;
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
     * Get teams 
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

        $this->divisionGameRepository->truncate();
        $this->divisionGameRepository->insert($games);        
    }

    /**
     * Insert positions
     *     
     */
    public function insertPositions(array $positions) {

        $this->divisionPositionRepository->truncate();
        $this->divisionPositionRepository->insert($positions);        
    }
    
}