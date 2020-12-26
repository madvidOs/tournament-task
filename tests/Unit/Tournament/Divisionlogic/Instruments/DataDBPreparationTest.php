<?php

namespace Tests\Unit\Tournament\DivisionsLogic\Instruments;

use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBPreparation;
use PHPUnit\Framework\TestCase;

class DataDBPreparationTest extends TestCase
{

    protected function setUp(): void
    {        

    }

    protected function tearDown():void
    {       
        
    }


    /**
     * Test getGamesDataForInsert method
     * 
     * @dataProvider gamesDataProvider
     *
     * @return void
     */
    public function testGetGamesDataForInsert(array $games, array $result)
    {
        $cook = new DataDBPreparation;
        $insert = $cook->getGamesDataForInsert($games);        

        $this->assertEquals($insert, $result);        
    }

    /**
     * Test getPositionsDataForInsert method
     * 
     * @dataProvider scorePositionsDataProvider
     *
     * @return void
     */
    public function testGetPositionsDataForInsert(
        array $score, 
        array $positions, 
        array $result
    ) {
        $cook = new DataDBPreparation;
        $insert = $cook->getPositionsDataForInsert($score, $positions);

        $this->assertEquals($insert, $result);        
    }


    public function gamesDataProvider()
    {
        return [
            [
                [
                    1 => [            
                        0 => [
                            'idTeam1' => 1,
                            'idTeam2' => 2,
                            'goalTeam1' => 0,
                            'goalTeam2' => 1,
                            'scoreTeam1' => 0,
                            'scoreTeam2' =>1,
                        ],
                        1 => [
                            'idTeam1' => 1,
                            'idTeam2' => 3,
                            'goalTeam1' => 1,
                            'goalTeam2' => 0,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 0,
                        ],
                        2 => [
                            'idTeam1' => 2,
                            'idTeam2' => 3,
                            'goalTeam1' => 1,
                            'goalTeam2' => 0,
                            'scoreTeam1' => 1,
                            'scoreTeam2' =>0,
                        ],
                    ]
                ],
                [
                    0 => [
                        'id_division' => 1,
                        'id_team1' => 1,
                        'id_team2' => 2,
                        'goal_team1' => 0,
                        'goal_team2' => 1,
                        'score_team1' => 0,
                        'score_team2' => 1,
                    ],
                    1 => [
                        'id_division' => 1,
                        'id_team1' => 1,
                        'id_team2' => 3,
                        'goal_team1' => 1,
                        'goal_team2' => 0,
                        'score_team1' => 1,
                        'score_team2' => 0,
                    ],
                    2 => [
                        'id_division' => 1,
                        'id_team1' => 2,
                        'id_team2' => 3,
                        'goal_team1' => 1,
                        'goal_team2' => 0,
                        'score_team1' => 1,
                        'score_team2' => 0 ,
                    ],
                ]
            ],           
        ];
    }

    public function scorePositionsDataProvider()
    {
        return [
            [
                [
                    1 => [            
                        1 => 2,
                        2 => 4,
                        3 => 4
                    ]
                ],
                [
                    1 => [            
                        1 => 7,
                        2 => 2,
                        3 => 3
                    ]
                ],
                [
                    [
                        'id_division' => 1,
                        'id_team' => 1,
                        'score' => 2,
                        'position' => 7,
                    ],
                    [
                        'id_division' => 1,
                        'id_team' => 2,
                        'score' => 4,
                        'position' => 2,
                    ],
                    [
                        'id_division' => 1,
                        'id_team' => 3,
                        'score' => 4,
                        'position' => 3,
                    ],
                ],
            ],           
        ];
    }

    
}
