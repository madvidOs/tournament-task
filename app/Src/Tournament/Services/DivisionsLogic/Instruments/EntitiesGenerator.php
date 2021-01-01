<?php

namespace App\Src\Tournament\Services\DivisionsLogic\Instruments;

class EntitiesGenerator
{
    /**
     * Create games
     *
     * @return array
     */
    public function createGamesResults(array $teams)
    {
        $games = [];

        $values = array_values($teams);
        $length = count($values);
        for ($i = 0; $i < $length; $i++) {
            for ($j = $i + 1; $j < $length; $j++) {
                $games[] = $this->_generateGame($values[$i]['teamId'], $values[$j]['teamId']);
            }
        }

        return $games;
    }

    /**
     * Count score
     *
     * @return array
     */
    public function countScore(array $games)
    {
        $score = [];

        foreach ($games as $game) {
            if (!isset($score[$game['idTeam1']])) {
                $score[$game['idTeam1']] = 0;
            }
            if (!isset($score[$game['idTeam2']])) {
                $score[$game['idTeam2']] = 0;
            }
            if ($game['scoreTeam1'] == '1') {
                $score[$game['idTeam1']]++;
            }
            if ($game['scoreTeam2'] == '1') {
                $score[$game['idTeam2']]++;
            }
        }

        return $score;
    }

    /**
     * Count positions
     *
     * @return array
     */
    public function countPositions(array $score)
    {
        //create position order
        arsort($score);

        //set positions
        $i = 1;
        $result = [];
        foreach ($score as $key => $value) {
            $result[$i++] = $key;
        }

        //set id as key, position as value
        $result = array_flip($result);
        ksort($result);


        return $result;
    }


    /**
     * Create result for a single game
     *
     * @return array
     */
    private function _generateGame($team1, $team2)
    {
        $goalsTeam1 = random_int(0, 1);
        $goalsTeam2 = (int)!$goalsTeam1;

        return [
            'idTeam1' => $team1,
            'idTeam2' => $team2,
            'goalTeam1' => $goalsTeam1,
            'goalTeam2' => $goalsTeam2,
            'scoreTeam1' => $goalsTeam1,
            'scoreTeam2' => $goalsTeam2,
        ];
    }
}
