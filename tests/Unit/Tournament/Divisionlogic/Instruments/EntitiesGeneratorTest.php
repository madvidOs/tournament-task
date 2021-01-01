<?php

namespace Tests\Unit\Tournament\DivisionsLogic\Instruments;

use App\Src\Tournament\Services\DivisionsLogic\Instruments\EntitiesGenerator;
use PHPUnit\Framework\TestCase;

class EntitiesGeneratorTest extends TestCase
{
    /**
     * Test createGamesResults method
     * 
     * @dataProvider teamsDataProvider
     *
     * @return void
     */
    public function testCreateGamesResults(array $teams)
    {
        $generator = new EntitiesGenerator;
        $games = $generator->createGamesResults($teams);

        $this->assertCount(28, $games);
        $this->assertArrayHasKey('idTeam1', $games[1]);
        $this->assertArrayHasKey('idTeam2', $games[1]);
        $this->assertArrayHasKey('goalTeam1', $games[1]);
        $this->assertArrayHasKey('goalTeam2', $games[1]);
        $this->assertArrayHasKey('scoreTeam1', $games[1]);
        $this->assertArrayHasKey('scoreTeam2', $games[1]);
    }

    /**
     * Test countScore method
     * 
     * @dataProvider gamesDataProvider
     *
     * @return void
     */
    public function testCountScore(array $games, $result)
    {
        $generator = new EntitiesGenerator;
        $score = $generator->countScore($games);

        $this->assertEquals($result, $score);
    }


    /**
     * Test countPositions method
     * 
     * @dataProvider scoreDataProvider
     * 
     * @return void
     */
    public function testCountPositions(array $score, $result)
    {
        $generator = new EntitiesGenerator;
        $positions = $generator->countPositions($score);

        $this->assertEquals($result, $positions);
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
            [1, 2]
        );

        $this->assertArrayHasKey('idTeam1', $game);
        $this->assertArrayHasKey('idTeam2', $game);
        $this->assertArrayHasKey('goalTeam1', $game);
        $this->assertArrayHasKey('goalTeam2', $game);
        $this->assertArrayHasKey('scoreTeam1', $game);
        $this->assertArrayHasKey('scoreTeam2', $game);
    }

    /**
     * Teams data provider
     * 
     * @return array
     */
    public function teamsDataProvider()
    {
        return [
            [[
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
                4 => [
                    'teamId' => 4,
                    'divisionId' => 1,
                    'teamName' => 'D',
                ],
                5 => [
                    'teamId' => 5,
                    'divisionId' => 1,
                    'teamName' => 'E',
                ],
                6 => [
                    'teamId' => 6,
                    'divisionId' => 1,
                    'teamName' => 'F',
                ],
                7 => [
                    'teamId' => 7,
                    'divisionId' => 1,
                    'teamName' => 'G',
                ],
                8 => [
                    'teamId' => 8,
                    'divisionId' => 1,
                    'teamName' => 'H',
                ],
            ]],
        ];
    }

    /**
     * Games data provider
     * 
     * @return array
     */
    public function gamesDataProvider()
    {
        return [
            [
                [
                    0 => [
                        'idTeam1' => 1,
                        'idTeam2' => 2,
                        'goalTeam1' => 0,
                        'goalTeam2' => 1,
                        'scoreTeam1' => 0,
                        'scoreTeam2' => 1,
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
                        'scoreTeam2' => 0,
                    ],
                ],
                [
                    1 => 1,
                    2 => 2,
                    3 => 0,
                ]
            ],
        ];
    }

    /**
     * Score data provider
     * 
     * @return array
     */
    public function scoreDataProvider()
    {
        return [
            [
                [
                    1 => 1,
                    2 => 2,
                    3 => 0,
                ],
                [
                    1 => 2,
                    2 => 1,
                    3 => 3
                ]
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
