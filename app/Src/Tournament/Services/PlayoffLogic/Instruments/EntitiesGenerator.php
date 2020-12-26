<?php

namespace App\Src\Tournament\Services\PlayoffLogic\Instruments;

class EntitiesGenerator {

    /**
     * get participants
     *
     * @return array
     */
    public function getParticipants(array $positions) {        

        $result = [];
        foreach($positions as $divisionId =>  $dp) {

            foreach ($dp as $idTeam => $position) {                
                if ($position >= 1 && $position <= 4 ) {
                    $result[] = [
                        'idTeam' => $idTeam,
                        'idDivision' => $divisionId,
                        'position' => $position,
                    ];
                }
            }           
        }         

        return $result;
    }    
    
    /**
     * get Level 1 Bracket
     *
     * @return array
     */
    public function getLevel1Bracket(array $participants) {            

        $result = [];
        foreach ($participants as $p) {
            $groupId = $p['idDivision'] == 1
                ? $p['position']
                : 5 - $p['position']
            ;    
            $result[] = [
                'idTeam' => $p['idTeam'],
                'idGroup' => $groupId,
                'level' => 1
            ];
        }
        
        //dd($result);

        return $result;
    }     

    /**
     * get Level 2 Bracket
     *
     * @return array
     */
    public function getLevel2Bracket(array $games) {       

        //var_dump($games);

        $result = [];
        foreach ($games as $g) {            

            $groupId = (int)ceil((float)$g['idGroup']/(float)2);

            if ($g['goalTeam1'] > $g['goalTeam2']) {
                $result[] = [
                    'idTeam' => $g['idTeam1'],
                    'idGroup' => $groupId,
                    'level' => 2
                ];
            } elseif ($g['goalTeam1'] < $g['goalTeam2']) {
                $result[] = [
                    'idTeam' => $g['idTeam2'],
                    'idGroup' => $groupId,
                    'level' => 2
                ];
            }            
        }
        
        //var_dump($result);exit;

        return $result;
    }     

    /**
     * get Level 3 Bracket
     *
     * @return array
     */
    public function getLevel3Bracket(array $games) {            

        $result = [];
        //var_dump($games);
        foreach ($games as $g) {

            if ($g['goalTeam1'] > $g['goalTeam2']) {
                $result[] = [
                    'idTeam' => $g['idTeam1'],
                    'idGroup' => 1,
                    'level' => 3
                ];
                $result[] = [
                    'idTeam' => $g['idTeam2'],
                    'idGroup' => 2,
                    'level' => 3
                ];
            } elseif ($g['goalTeam1'] < $g['goalTeam2']) {
                $result[] = [
                    'idTeam' => $g['idTeam2'],
                    'idGroup' => 1,
                    'level' => 3
                ];
                $result[] = [
                    'idTeam' => $g['idTeam1'],
                    'idGroup' => 2,
                    'level' => 3
                ];
            }            
        }
        
        //var_dump($result);exit;

        return $result;
    }  
    
    /**
     * get Winners
     *
     * @return array
     */
    public function getWinners(array $games) {            

        $result = [];      
        //var_dump($games);
        foreach ($games as $g) {            
            $counter = $g['idGroup'] == 1
                ? 1
                : 3
            ;    
            if ($g['goalTeam1'] > $g['goalTeam2']) {
                $result[$counter] = [
                    'idTeam' => $g['idTeam1'],
                    'position' => $counter                        
                ];
                $result[$counter+1] = [
                    'idTeam' => $g['idTeam2'],                        
                    'position' => $counter+1
                ];
                
            } elseif ($g['goalTeam1'] < $g['goalTeam2']) {
                $result[$counter] = [
                    'idTeam' => $g['idTeam2'],
                    'position' => $counter 
                ];
                $result[$counter+1] = [
                    'idTeam' => $g['idTeam1'],                        
                    'position' => $counter+1
                ];
            }
        }
        
        //var_dump($result);exit;

        return $result;
    }

    /**
     * get Team Names
     *
     * @return array
     */
    public function getTeamsNames(array $divisions, array $teams) {
        $result = [];   
        //var_dump($divisions, $teams);
        foreach ($teams as $team) {            
            $result[$team['teamId']] = [
                'idTeam' => $team['teamId'],                
                'teamName' => $team['teamName'] . ' (Division ' . $divisions[$team['divisionId']]['divisionName'] . ')',
            ];
        }

        //var_dump($result);exit;

        return $result;
    }

    /**
     * create games
     *
     * @return array
     */
    public function createGamesResults(array $teams) {     
        
        //var_dump($teams);

        $games = [];        

        $tmp = [];
        foreach ($teams as $team) {
            //var_dump($team);
            if (isset($tmp[$team['idGroup']])) {
                $games[$team['idGroup']] = $this->generateGame($tmp[$team['idGroup']]['idTeam'], $team['idTeam'], $team['idGroup']);
                //var_dump($games);
            } else {
                $tmp[$team['idGroup']] = $team;
            }
        }        
        
        ksort($games);

        //var_dump($games);exit;

        return $games;
    }         
    

    /**
     * create result for a single game
     *
     * @return array
     */
    private function generateGame($team1, $team2, $groupId) {
        $goalsTeam1 = random_int(0,1);
        $goalsTeam2 = (int)!$goalsTeam1;

        return [
            'idTeam1' => $team1,
            'idTeam2' => $team2,
            'goalTeam1' => $goalsTeam1,
            'goalTeam2' => $goalsTeam2,
            'idGroup'   => $groupId
        ];
    }    
}