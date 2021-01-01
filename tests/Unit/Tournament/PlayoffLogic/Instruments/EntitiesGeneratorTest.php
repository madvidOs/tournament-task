<?php

namespace Tests\Unit\Tournament\PlayoffLogic\Instruments;

use App\Src\Tournament\Services\PlayoffLogic\Instruments\EntitiesGenerator;
use PHPUnit\Framework\TestCase;

class EntitiesGeneratorTest extends TestCase
{
    /**
     * Test getParticipants method
     * 
     * @dataProvider participantsDataProvider
     *
     * @return void
     */
    public function testGetParticipants(array $positions, $result)
    {
        $generator = new EntitiesGenerator;
        $participants = $generator->getParticipants($positions);

        $this->assertEquals($result, $participants);
    }

    /**
     * Test getLevel1Bracket method
     * 
     * @dataProvider level1BracketDataProvider
     *
     * @return void
     */
    public function testGetLevel1Bracket(array $participants, $result)
    {
        $generator = new EntitiesGenerator;
        $level1Data = $generator->getLevel1Bracket($participants);

        $this->assertEquals($result, $level1Data);
    }

    /**
     * Test getLevel2Bracket method
     * 
     * @dataProvider level2BracketDataProvider
     *
     * @return void
     */
    public function testGetLevel2Bracket(array $games, $result)
    {
        $generator = new EntitiesGenerator;
        $level2Data = $generator->getLevel2Bracket($games);

        $this->assertEquals($result, $level2Data);
    }

    /**
     * Test getLevel3Bracket method
     * 
     * @dataProvider level3BracketDataProvider
     *
     * @return void
     */
    public function testGetLevel3Bracket(array $games, $result)
    {
        $generator = new EntitiesGenerator;
        $level3Data = $generator->getLevel3Bracket($games);

        $this->assertEquals($result, $level3Data);
    }

    /**
     * Test getWinners method
     * 
     * @dataProvider winnersDataProvider
     *
     * @return void
     */
    public function testGetWinners(array $games, $result)
    {
        $generator = new EntitiesGenerator;
        $winners = $generator->getWinners($games);

        $this->assertEquals($result, $winners);
    }

    /**
     * Test getTeamsNames method
     * 
     * @dataProvider teamNamesDataProvider
     *
     * @return void
     */
    public function testGetTeamsNames(
        array $divisions,
        array $teams,
        array $result
    ) {
        $generator = new EntitiesGenerator;
        $names = $generator->getTeamsNames(
            $divisions,
            $teams
        );

        $this->assertEquals($result, $names);
    }

    /**
     * Test createGamesResults method
     * 
     * @dataProvider teamsDataProvider
     *
     * @return void
     */
    public function testCreateGamesResults(array $teams, $count)
    {
        $generator = new EntitiesGenerator;
        $games = $generator->createGamesResults($teams);

        $this->assertCount($count, $games);
        $this->assertArrayHasKey('idTeam1', $games[1]);
        $this->assertArrayHasKey('idTeam2', $games[1]);
        $this->assertArrayHasKey('goalTeam1', $games[1]);
        $this->assertArrayHasKey('goalTeam2', $games[1]);
        $this->assertArrayHasKey('idGroup', $games[1]);
    }

    /**
     * Test generateGame method          
     * 
     * @return void
     */
    public function testGenerateGame()
    {
        $generator = new EntitiesGenerator;
        $game = self::callMethod(
            $generator,
            '_generateGame',
            [1, 2, 1]
        );

        $this->assertArrayHasKey('idTeam1', $game);
        $this->assertArrayHasKey('idTeam2', $game);
        $this->assertArrayHasKey('goalTeam1', $game);
        $this->assertArrayHasKey('goalTeam2', $game);
        $this->assertArrayHasKey('idGroup', $game);
    }


    /**
     * Participants data provider
     * 
     * @return array
     */
    public function participantsDataProvider()
    {
        return [
            [
                [
                    1 => [
                        1 => 8,
                        2 => 6,
                        3 => 2,
                        4 => 3,
                        5 => 4,
                        6 => 7,
                        7 => 5,
                        8 => 1,
                    ],
                    2 => [
                        9 => 7,
                        10 => 1,
                        11 => 4,
                        12 => 5,
                        13 => 6,
                        14 => 2,
                        15 => 3,
                        16 => 8,
                    ],
                ],
                [
                    0 => [
                        'idTeam' => 3,
                        'idDivision' => 1,
                        'position' => 2,
                    ],
                    1 => [
                        'idTeam' => 4,
                        'idDivision' => 1,
                        'position' => 3,
                    ],
                    2 => [
                        'idTeam' => 5,
                        'idDivision' => 1,
                        'position' => 4,
                    ],
                    3 => [
                        'idTeam' => 8,
                        'idDivision' => 1,
                        'position' => 1,
                    ],
                    4 => [
                        'idTeam' => 10,
                        'idDivision' => 2,
                        'position' => 1,
                    ],
                    5 => [
                        'idTeam' => 11,
                        'idDivision' => 2,
                        'position' => 4,
                    ],
                    6 => [
                        'idTeam' => 14,
                        'idDivision' => 2,
                        'position' => 2,
                    ],
                    7 => [
                        'idTeam' => 15,
                        'idDivision' => 2,
                        'position' => 3,
                    ],
                ]
            ],
        ];
    }

    /**
     * Level 1 bracket data provider
     * 
     * @return array
     */
    public function level1BracketDataProvider()
    {
        return [
            [
                [
                    0 => [
                        'idTeam' => 1,
                        'idDivision' => 1,
                        'position' => 2,
                    ],
                    1 => [
                        'idTeam' => 2,
                        'idDivision' => 1,
                        'position' => 1,
                    ],
                    2 => [
                        'idTeam' => 4,
                        'idDivision' => 1,
                        'position' => 3,
                    ],
                    3 => [
                        'idTeam' => 5,
                        'idDivision' => 1,
                        'position' => 4,
                    ],
                    4 => [
                        'idTeam' => 9,
                        'idDivision' => 2,
                        'position' => 1,
                    ],
                    5 => [
                        'idTeam' => 11,
                        'idDivision' => 2,
                        'position' => 3,
                    ],
                    6 => [
                        'idTeam' => 13,
                        'idDivision' => 2,
                        'position' => 4,
                    ],
                    7 => [
                        'idTeam' => 15,
                        'idDivision' => 2,
                        'position' => 2,
                    ],
                ],
                [
                    0 => [
                        'idTeam' => 1,
                        'idGroup' => 2,
                        'level' => 1,
                    ],
                    1 => [
                        'idTeam' => 2,
                        'idGroup' => 1,
                        'level' => 1,
                    ],
                    2 => [
                        'idTeam' => 4,
                        'idGroup' => 3,
                        'level' => 1,
                    ],
                    3 => [
                        'idTeam' => 5,
                        'idGroup' => 4,
                        'level' => 1,
                    ],
                    4 => [
                        'idTeam' => 9,
                        'idGroup' => 4,
                        'level' => 1,
                    ],
                    5 => [
                        'idTeam' => 11,
                        'idGroup' => 2,
                        'level' => 1,
                    ],
                    6 => [
                        'idTeam' => 13,
                        'idGroup' => 1,
                        'level' => 1,
                    ],
                    7 => [
                        'idTeam' => 15,
                        'idGroup' => 3,
                        'level' => 1,
                    ],
                ]
            ],
        ];
    }

    /**
     * Level 2 bracket data provider
     * 
     * @return array
     */
    public function level2BracketDataProvider()
    {
        return [
            [
                [
                    1 => [
                        'idTeam1' => 6,
                        'idTeam2' => 14,
                        'goalTeam1' => 1,
                        'goalTeam2' => 0,
                        'idGroup' => 1,
                    ],
                    2 => [
                        'idTeam1' => 1,
                        'idTeam2' => 11,
                        'goalTeam1' => 0,
                        'goalTeam2' => 1,
                        'idGroup' => 2,
                    ],
                    3 => [
                        'idTeam1' => 2,
                        'idTeam2' => 9,
                        'goalTeam1' => 0,
                        'goalTeam2' => 1,
                        'idGroup' => 3,
                    ],
                    4 => [
                        'idTeam1' => 4,
                        'idTeam2' => 12,
                        'goalTeam1' => 0,
                        'goalTeam2' => 1,
                        'idGroup' => 4,
                    ],
                ],
                [
                    0 => [
                        'idTeam' => 6,
                        'idGroup' => 1,
                        'level' => 2,
                    ],
                    1 => [
                        'idTeam' => 11,
                        'idGroup' => 1,
                        'level' => 2,
                    ],
                    2 => [
                        'idTeam' => 9,
                        'idGroup' => 2,
                        'level' => 2,
                    ],
                    3 => [
                        'idTeam' => 12,
                        'idGroup' => 2,
                        'level' => 2,
                    ],
                ]
            ],
        ];
    }

    /**
     * Level 3 bracket data provider
     * 
     * @return array
     */
    public function level3BracketDataProvider()
    {
        return [
            [
                [
                    1 => [
                        'idTeam1' => 6,
                        'idTeam2' => 13,
                        'goalTeam1' => 0,
                        'goalTeam2' => 1,
                        'idGroup' => 1,
                    ],
                    2 => [
                        'idTeam1' => 12,
                        'idTeam2' => 2,
                        'goalTeam1' => 0,
                        'goalTeam2' => 1,
                        'idGroup' => 2,
                    ],
                ],
                [
                    0 => [
                        'idTeam' => 13,
                        'idGroup' => 1,
                        'level' => 3,
                    ],
                    1 => [
                        'idTeam' => 6,
                        'idGroup' => 2,
                        'level' => 3,
                    ],
                    2 => [
                        'idTeam' => 2,
                        'idGroup' => 1,
                        'level' => 3,
                    ],
                    3 => [
                        'idTeam' => 12,
                        'idGroup' => 2,
                        'level' => 3,
                    ],
                ]
            ],
        ];
    }

    /**
     * Winners data provider
     * 
     * @return array
     */
    public function winnersDataProvider()
    {
        return [
            [
                [
                    1 => [
                        'idTeam1' => 10,
                        'idTeam2' => 2,
                        'goalTeam1' => 1,
                        'goalTeam2' => 0,
                        'idGroup' => 1,
                    ],
                    2 => [
                        'idTeam1' => 5,
                        'idTeam2' => 13,
                        'goalTeam1' => 0,
                        'goalTeam2' => 1,
                        'idGroup' => 2,
                    ],
                ],
                [
                    1 => [
                        'idTeam' => 10,
                        'position' => 1,
                    ],
                    2 => [
                        'idTeam' => 2,
                        'position' => 2,
                    ],
                    3 => [
                        'idTeam' => 13,
                        'position' => 3,
                    ],
                    4 => [
                        'idTeam' => 5,
                        'position' => 4,
                    ],
                ]
            ],
        ];
    }

    /**
     * Teams names data provider
     * 
     * @return array
     */
    public function teamNamesDataProvider()
    {
        return [
            [
                [
                    1 => [
                        'divisionId' => 1,
                        'divisionName' => 'A',
                    ],
                    2 => [
                        'divisionId' => 2,
                        'divisionName' => 'B',
                    ],
                ],
                [
                    1 => [
                        'teamId' => 1,
                        'divisionId' => 1,
                        'teamName' => 'A',
                    ],
                    2 => [
                        'teamId' => 2,
                        'divisionId' => 1,
                        'teamName' => 'B',
                    ],
                    3 => [
                        'teamId' => 3,
                        'divisionId' => 1,
                        'teamName' => 'C',
                    ],
                ],
                [
                    1 => [
                        'idTeam' => 1,
                        'teamName' => 'A (Division A)',
                    ],
                    2 => [
                        'idTeam' => 2,
                        'teamName' => 'B (Division A)',
                    ],
                    3 => [
                        'idTeam' => 3,
                        'teamName' => 'C (Division A)',
                    ],
                ]
            ],
        ];
    }

    /**
     * Teams data provider
     * 
     * @return array
     */
    public function teamsDataProvider()
    {
        return [
            [
                [
                    0 => [
                        'idTeam' => 1,
                        'idGroup' => 4,
                        'level' => 1,
                    ],
                    1 => [
                        'idTeam' => 2,
                        'idGroup' => 1,
                        'level' => 1,
                    ],
                    2 => [
                        'idTeam' => 6,
                        'idGroup' => 3,
                        'level' => 1,
                    ],
                    3 => [
                        'idTeam' => 8,
                        'idGroup' => 2,
                        'level' => 1,
                    ],
                    4 => [
                        'idTeam' => 9,
                        'idGroup' => 3,
                        'level' => 1,
                    ],
                    5 => [
                        'idTeam' => 11,
                        'idGroup' => 2,
                        'level' => 1,
                    ],
                    6 => [
                        'idTeam' => 14,
                        'idGroup' => 1,
                        'level' => 1,
                    ],
                    7 => [
                        'idTeam' => 16,
                        'idGroup' => 4,
                        'level' => 1,
                    ],
                ],
                4
            ],

        ];
    }

    public static function callMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
