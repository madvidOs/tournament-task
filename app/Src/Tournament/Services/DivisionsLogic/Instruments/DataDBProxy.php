<?php

namespace App\Src\Tournament\Services\DivisionsLogic\Instruments;

use App\Src\Tournament\Repositories\DivisionGameRepository;
use App\Src\Tournament\Repositories\DivisionPositionRepository;
use App\Src\Tournament\Repositories\DivisionRepository;
use App\Src\Tournament\Repositories\DivisionTeamRepository;

class DataDBProxy
{
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
    public function getDivisions()
    {
        return $this->divisionRepository->all();
    }

    /**
     * Get teams 
     *
     * @return Collection
     */
    public function getTeams()
    {
        return $this->divisionTeamRepository->all();
    }

    /**
     * Insert games
     *    
     * @return void 
     */
    public function insertGames(array $games)
    {

        $this->divisionGameRepository->truncate();
        $this->divisionGameRepository->insert($games);
    }

    /**
     * Insert positions
     * 
     * @return void    
     */
    public function insertPositions(array $positions)
    {

        $this->divisionPositionRepository->truncate();
        $this->divisionPositionRepository->insert($positions);
    }
}
