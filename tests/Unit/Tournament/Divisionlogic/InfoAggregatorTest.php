<?php

namespace Tests\Unit\Tournament\DivisionsLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoAggregator;
use PHPUnit\Framework\TestCase;

class InfoAggregatorTest extends TestCase
{
    protected function setUp(): void
    {
    }

    protected function tearDown():void
    {        
        
    }  


    /**
     * Test setDivisions, getDivisions method
     * 
     * @dataProvider divisionsDataProvider
     *
     * @return void
     */
    public function testGetSetDivisions($srcDivisions, $result)
    {        
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setDivisions($srcDivisions); 
        $divisions = $infoAggregator->getDivisions();    

        $this->assertEquals($divisions,$result);

    }
    

    /**
     * Test setTeams, getAllTeams, getTeamsByDivision,
     *      getTeamsByDivisionId methods
     * 
     * @depends testGetSetDivisions
     * @dataProvider teamsDataProvider
     *
     * @return void
     */
    public function testGetSetTeams(
        $srcDivisions,
        $srcTeams,
        $allTeamsCount,
        $teamsInDivisionsCount,
        $teamsByDivisionCount
    ) {
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setDivisions($srcDivisions); 
        $infoAggregator->setTeams($srcTeams);
        
        $allTeams = $infoAggregator->getAllTeams(); 
        
        $this->assertCount($allTeamsCount, $allTeams);
        $this->assertArrayHasKey('teamId', $allTeams[1]);
        $this->assertArrayHasKey('divisionId', $allTeams[1]);
        $this->assertArrayHasKey('teamName', $allTeams[1]);

        $teamsInDivisions = $infoAggregator->getTeamsInDivisions();        
        $this->assertCount($teamsInDivisionsCount, $teamsInDivisions);
        $this->assertArrayHasKey('teamId', $teamsInDivisions[1][1]);
        $this->assertArrayHasKey('divisionId', $teamsInDivisions[1][1]);
        $this->assertArrayHasKey('teamName', $teamsInDivisions[1][1]);

        $teamsByDivision = $infoAggregator->getTeamsByDivisionId(1);        
        $this->assertCount($teamsByDivisionCount, $teamsByDivision);
        $this->assertArrayHasKey('teamId', $teamsByDivision[1]);
        $this->assertArrayHasKey('divisionId', $teamsByDivision[1]);
        $this->assertArrayHasKey('teamName', $teamsByDivision[1]);
    }


    /**
     * Test setGamesByDivisionId, getGamesByDivisionId 
     *      getGamesInDivisions methods
     * 
     * @dataProvider gamesDataProvider
     *
     * @return void
     */
    public function testGetSetGames($divisionId, $srcGames, $allGamesResult)
    {        
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setGamesByDivisionId($divisionId, $srcGames);
        $games = $infoAggregator->getGamesByDivisionId($divisionId);
        $allGames = $infoAggregator->getGamesInDivisions();

        $this->assertEquals($games, $srcGames);
        $this->assertEquals($allGames, $allGamesResult);
    }

    /**
     * Test setScoreByDivisionId, getScoreByDivisionId, 
     *      getScoreInDivisions methods
     * 
     * @dataProvider scoreDataProvider
     *
     * @return void
     */
    public function testGetSetScore($divisionId, $score, $allScoreResult)
    { 
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setScoreByDivisionId($divisionId, $score);
        $scoreByDivision = $infoAggregator->getScoreByDivisionId($divisionId);
        $allScore = $infoAggregator->getScoreInDivisions();        

        $this->assertEquals($scoreByDivision, $score);
        $this->assertEquals($allScore, $allScoreResult);        
    }

    /**
     * Test setPositionsByDivisionId, getPositionsByDivisionId, 
     *      getPositionsInDivisions methods
     * 
     * @dataProvider positionsDataProvider
     *
     * @return void
     */
    public function testGetSetPositions(
        $divisionId, 
        $positions, 
        $allPositionsResult
    ) { 
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setPositionsByDivisionId($divisionId, $positions);
        $positionsByDivision = $infoAggregator->getPositionsByDivisionId($divisionId);
        $allPositions = $infoAggregator->getPositionsInDivisions();        

        $this->assertEquals($positionsByDivision, $positions);
        $this->assertEquals($allPositions, $allPositionsResult);        
        
    }
    

    /**
     * Test toArray method
     * 
     * @depends testGetSetDivisions
     * @depends testGetSetTeams
     * @depends testGetSetGames
     * @depends testGetSetScore
     * @depends testGetSetPositions
     * 
     * @dataProvider toArrayDataProvider
     *
     * @return void
     */
    public function testToArray(
        $divisionId,
        $srcDivisions, 
        $srcTeams,
        $srcGames,
        $srcScore,
        $srcPositions
    ) {  
        $infoAggregator = new InfoAggregator;        
        $infoAggregator->setDivisions($srcDivisions); 
        $infoAggregator->setTeams($srcTeams);
        $infoAggregator->setGamesByDivisionId($divisionId, $srcGames);
        $infoAggregator->setScoreByDivisionId($divisionId, $srcScore);
        $infoAggregator->setPositionsByDivisionId($divisionId, $srcPositions);

        $response = $infoAggregator->toArray([
            'teams', 
            'games', 
            'score', 
            'positions'
        ]);

        //var_dump($response);exit;

        $this->assertArrayHasKey('divisions', $response);        
        $this->assertArrayHasKey('teams', $response['divisions'][$divisionId]);
        $this->assertArrayHasKey('games', $response['divisions'][$divisionId]);
        $this->assertArrayHasKey('score', $response['divisions'][$divisionId]);
        $this->assertArrayHasKey('positions', $response['divisions'][$divisionId]);        
    }


    public function divisionsDataProvider()
    {
        return [
            [
                [
                    new class {
                        public $id = 1; 
                        public $name = 'A';
                    },
                    new class {
                        public $id = 2; 
                        public $name = 'B';
                    },                
                ],
                [
                    1 => [
                        "divisionId" => 1,
                        "divisionName" => "A"
                    ],
                    2 => [
                        "divisionId" => 2,
                        "divisionName" => "B"
                    ]
                ],
            ],           
        ];
    }

    public function teamsDataProvider()
    {
        return [
            [
                [
                    new class {
                        public $id = 1; 
                        public $name = 'A';
                    },
                    new class {
                        public $id = 2; 
                        public $name = 'B';
                    },                
                ],
                [
                    0 => new class {
                        public $id = 1;
                        public $id_division = 1;
                        public $name = "A";
                    },
                    1 => new class {
                        public $id = 2;
                        public $id_division = 1;
                        public $name = "B";
                    },
                    2 => new class {
                        public $id = 3;
                        public $id_division = 1;
                        public $name = "C";
                    },
                    3 => new class {
                        public $id = 4;
                        public $id_division = 1;
                        public $name = "D";
                    },
                    4 => new class {
                        public $id = 5;
                        public $id_division = 1;
                        public $name = "E";
                    },
                    5 => new class {
                        public $id = 6;
                        public $id_division = 1;
                        public $name = "F";
                    },
                    6 => new class {
                        public $id = 7;
                        public $id_division = 1;
                        public $name = "G";
                    },
                    7 => new class {
                        public $id = 8;
                        public $id_division = 1;
                        public $name = "H";
                    },
                    8 => new class {
                        public $id = 9;
                        public $id_division = 2;
                        public $name = "I";
                    },
                    9 => new class {
                        public $id = 10;
                        public $id_division = 2;
                        public $name = "J";
                    },
                    10 => new class {
                        public $id = 11;
                        public $id_division = 2;
                        public $name = "K";
                    },
                    11 => new class {
                        public $id = 12;
                        public $id_division = 2;
                        public $name = "L";
                    },
                    12 => new class {
                        public $id = 13;
                        public $id_division = 2;
                        public $name = "M";
                    },
                    13 => new class {
                        public $id = 14;
                        public $id_division = 2;
                        public $name = "N";
                    },
                    14 => new class {
                        public $id = 15;
                        public $id_division = 2;
                        public $name = "O";
                    },
                    15 => new class {
                        public $id = 16;
                        public $id_division = 2;
                        public $name = "P";
                    },
                ],
                16,
                2,
                8
            ],           
        ];
    }

    public function gamesDataProvider()
    {
        return [
            [
                1,
                [
                    0 => [
                        "idTeam1" => 1,
                        "idTeam2" => 2,
                        "goalTeam1" => 1,
                        "goalTeam2" => 0,
                        "scoreTeam1" => 1,
                        "scoreTeam2" => 0,
                    ],
                    1 => [
                        "idTeam1" => 1,
                        "idTeam2" => 3,
                        "goalTeam1" => 0,
                        "goalTeam2" => 1,
                        "scoreTeam1" => 0,
                        "scoreTeam2" => 1,
                    ]
                ],
                [
                    1 => [
                        0 =>  [
                            'idTeam1' => 1,
                            'idTeam2' => 2,
                            'goalTeam1' => 1,
                            'goalTeam2' => 0,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 0,
                        ],
                        1 =>  [
                            'idTeam1' => 1,
                            'idTeam2' => 3,
                            'goalTeam1' => 0,
                            'goalTeam2' => 1,
                            'scoreTeam1' => 0,
                            'scoreTeam2' => 1,
                        ]                
                    ]                
                ]
                
            ],           
        ];
    }


    public function scoreDataProvider()
    {
        return [
            [
                1,
                [
                    1 => 3,
                    2 => 5,
                    3 => 3,
                    4 => 6,
                    5 => 3,
                    6 => 3,
                    7 => 3,
                    8 => 2,
                ],
                [
                    1 => [
                        1 => 3,
                        2 => 5,
                        3 => 3,
                        4 => 6,
                        5 => 3,
                        6 => 3,
                        7 => 3,
                        8 => 2,
                    ]              
                ]
                
            ],           
        ];
    }


    public function positionsDataProvider()
    {
        return [
            [
                1,
                [
                    1 => 3,
                    2 => 4,
                    3 => 8,
                    4 => 6,
                    5 => 7,
                    6 => 2,
                    7 => 1,
                    8 => 5,
                ],
                [
                    1 => [
                        1 => 3,
                        2 => 4,
                        3 => 8,
                        4 => 6,
                        5 => 7,
                        6 => 2,
                        7 => 1,
                        8 => 5,
                    ]              
                ]
                
            ],           
        ];
    }


    public function toArrayDataProvider()
    {
        return [
            [
                1,
                [
                    new class {
                        public $id = 1; 
                        public $name = 'A';
                    },                    
                ],
                [
                    0 => new class {
                        public $id = 1;
                        public $id_division = 1;
                        public $name = "A";
                    },
                    1 => new class {
                        public $id = 2;
                        public $id_division = 1;
                        public $name = "B";
                    },
                ],
                [
                    0 => [
                        "idTeam1" => 1,
                        "idTeam2" => 2,
                        "goalTeam1" => 1,
                        "goalTeam2" => 0,
                        "scoreTeam1" => 1,
                        "scoreTeam2" => 0,
                    ],
                ],
                [
                    1 => 5
                ],
                [
                    1 => 1
                ]

            ],           
        ];
    }
    
}
