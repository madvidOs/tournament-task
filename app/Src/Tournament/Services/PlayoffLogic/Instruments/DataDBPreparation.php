<?php

namespace App\Src\Tournament\Services\PlayoffLogic\Instruments;

class DataDBPreparation
{

    /**
     * Prepare bracket
     *
     * @return array
     */
    public function getBracketDataForInsert(array $bracket)
    {        

        $result = [];
        foreach ($bracket as $bracket) {
            foreach ($bracket as $b) {
                $result[] = [
                    'level' => $b['level'],
                    'group_number' => $b['idGroup'],
                    'id_team' => $b['idTeam'],
                ];
            }
        }        

        return $result;
    }

    /**
     * Prepare participants
     *
     * @return array
     */
    public function getParticipantsDataForInsert(array $participants)
    {

        $result = [];
        
        foreach ($participants as $p) {
            $result[] = [
                'id_team' => $p['idTeam'],
                'id_division' => $p['idDivision'],
                'position' => $p['position'],
            ];
        }        

        return $result;
    }

    /**
     * Prepare games
     *
     * @return array
     */
    public function getGamesDataForInsert(array $games)
    {
        $result = [];
        
        foreach ($games as $game) {
            foreach ($game as $g) {
                $result[] = [
                    'id_team1' => $g['idTeam1'],
                    'id_team2' => $g['idTeam2'],
                    'goal_team1' => $g['goalTeam1'],
                    'goal_team2' => $g['goalTeam2'],
                    'id_group' => $g['idGroup'],
                ];
            }
        }        

        return $result;
    }

    /**
     * Prepare winners
     *
     * @return array
     */
    public function getWinnersDataForInsert(array $winners)
    {

        $result = [];
        
        foreach ($winners as $w) {
            $result[] = [
                'id_team' => $w['idTeam'],
                'position' => $w['position'],
            ];
        }        

        return $result;
    }
}
