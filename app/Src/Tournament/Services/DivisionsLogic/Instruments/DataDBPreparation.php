<?php

namespace App\Src\Tournament\Services\DivisionsLogic\Instruments;

class DataDBPreparation
{
    /**
     * Prepare games
     *
     * @return array
     */
    public function getGamesDataForInsert(array $games)
    {

        $result = [];
        foreach ($games as $divisionId => $gamesArray) {
            foreach ($gamesArray as $ga) {
                $result[] = [
                    'id_division' => $divisionId,
                    'id_team1' => $ga['idTeam1'],
                    'id_team2' => $ga['idTeam2'],
                    'goal_team1' => $ga['goalTeam1'],
                    'goal_team2' => $ga['goalTeam2'],
                    'score_team1' => $ga['scoreTeam1'],
                    'score_team2' => $ga['scoreTeam2'],
                ];
            }
        }

        return $result;
    }

    /**
     * Prepare positions
     *
     * @return array
     */
    public function getPositionsDataForInsert(array $score, array $positions)
    {

        $result = [];

        foreach ($score as $divisionId => $scoreArray) {
            foreach ($scoreArray as $teamId => $data) {
                $result[] = [
                    'id_division' => $divisionId,
                    'id_team'   => $teamId,
                    'score'     => $data,
                    'position'  => $positions[$divisionId][$teamId],
                ];
            }
        }

        return $result;
    }
}
