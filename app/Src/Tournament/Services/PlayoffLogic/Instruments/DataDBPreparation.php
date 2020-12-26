<?php

namespace App\Src\Tournament\Services\PlayoffLogic\Instruments;

class DataDBPreparation {

    /**
     * prepare bracket
     *
     * @return array
     */
    public function getBracketDataForInsert(array $bracket) {    
        
        //var_dump($bracket);

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

        //var_dump($result);exit;

        return $result;
    }    

    /**
     * prepare participants
     *
     * @return array
     */
    public function getParticipantsDataForInsert(array $participants) {        

        $result = [];
        //var_dump($participants);
        foreach ($participants as $p) {
            $result[] = [
                'id_team' => $p['idTeam'],
                'id_division' => $p['idDivision'],
                'position' => $p['position'],
            ];            
        }

        //var_dump($result);exit;

        return $result;
    }    

    /**
     * prepare games
     *
     * @return array
     */
    public function getGamesDataForInsert(array $games) {        

        $result = [];
        //var_dump($games);
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

        //var_dump($result);exit;

        return $result;
    }

    /**
     * prepare winners
     *
     * @return array
     */
    public function getWinnersDataForInsert(array $winners) {        

        $result = [];
        //var_dump($winners);
        foreach ($winners as $w) {
            $result[] = [
                'id_team' => $w['idTeam'],                
                'position' => $w['position'],
            ];            
        }

        //var_dump($result);exit;

        return $result;
    }
    

}