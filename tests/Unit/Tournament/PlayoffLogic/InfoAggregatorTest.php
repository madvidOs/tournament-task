<?php

namespace Tests\Unit\Tournament\PlayoffLogic;

use App\Src\Tournament\Services\PlayoffLogic\InfoAggregator;
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
     * Test setParticipants, getParticipants method
     * 
     * @dataProvider participantsDataProvider
     *
     * @return void
     */
    public function testGetSetParticipants($srcParticipants)
    {        
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setParticipants($srcParticipants); 
        $participants = $infoAggregator->getParticipants();    

        $this->assertEquals($participants, $srcParticipants);

    }

    /**
     * Test setBracket, getBracket method
     * 
     * @dataProvider bracketDataProvider
     *
     * @return void
     */
    public function testGetSetBracket($srcBracket)
    {        
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setBracket($srcBracket); 
        $bracket = $infoAggregator->getBracket();    

        $this->assertEquals($bracket, $srcBracket);
    }

    /**
     * Test setGames, getGames,
     *      getWinnersGames method
     * 
     * @dataProvider gamesDataProvider
     *
     * @return void
     */
    public function testGetSetGames($srcGames, $srcWinnerGames)
    {        
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setGames($srcGames);         
        
        $games = $infoAggregator->getGames();
        $this->assertEquals($games, $srcGames);

        $winnersGames = $infoAggregator->getWinnersGames();
        $this->assertEquals($winnersGames, $srcWinnerGames);
    }


    /**
     * Test setWinners, getWinners method
     * 
     * @dataProvider winnersDataProvider
     *
     * @return void
     */
    public function testGetSetWinners($srcWinners)
    {        
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setWinners($srcWinners); 
        $winners = $infoAggregator->getWinners();    

        $this->assertEquals($winners, $srcWinners);
    }


    /**
     * Test setTeamsNames, getTeamsNames method
     * 
     * @dataProvider teamsNamesDataProvider
     *
     * @return void
     */
    public function testGetSetTeamsNames($srcTeamsNames)
    {        
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setTeamsNames($srcTeamsNames); 
        $teamsNames = $infoAggregator->getTeamsNames();    

        $this->assertEquals($teamsNames, $srcTeamsNames);
    }
    

    

    /**
     * Test toArray method
     * 
     * @depends testGetSetBracket
     * @depends testGetSetGames
     * @depends testGetSetWinners
     * @depends testGetSetTeamsNames
     *
     * @return void
     */
    public function testToArray() {  
        $infoAggregator = new InfoAggregator;
        $infoAggregator->setBracket([123]);
        $infoAggregator->setGames([345]);
        $infoAggregator->setWinners([678]);
        $infoAggregator->setTeamsNames([90]);

        $response = $infoAggregator->toArray([
            'bracket', 
            'games', 
            'winners', 
            'teamsNames'
        ]);        

        $this->assertArrayHasKey('playoff', $response);
        $this->assertArrayHasKey('bracket', $response['playoff']);
        $this->assertArrayHasKey('games', $response['playoff']);
        $this->assertArrayHasKey('winners', $response['playoff']);
        $this->assertArrayHasKey('teamsNames', $response['playoff']);      
    }


    public function participantsDataProvider()
    {
        return [
            [
                [
                    0 => [
                        'idTeam' => 1,
                        'idDivision' => 1,
                        'position' => 3,
                    ],    
                    1 => [
                        'idTeam' => 2,
                        'idDivision' => 1,
                        'position' => 4,
                    ],      
                ]
            ],           
        ];
    } 
    
    public function bracketDataProvider()
    {
        return [
            [
                [
                    1 => [    
                        0 => [        
                            'idTeam' => 1,
                            'idGroup' => 3,
                            'level' => 1,
                        ],    
                        1 => [        
                            'idTeam' => 3,
                            'idGroup' => 4,
                            'level' => 1,
                        ],    
                    ]      
                ]
            ],           
        ];
    }    

    public function gamesDataProvider()
    {
        return [
            [
                [
                    1 => [    
                        1 => [        
                            'idTeam1' => 6,
                            'idTeam2' => 15,
                            'goalTeam1' => 0,
                            'goalTeam2' => 1,
                            'idGroup' => 1,
                        ],    
                        2 => [        
                            'idTeam1' => 4,
                            'idTeam2' => 12,
                            'goalTeam1' => 0,
                            'goalTeam2' => 1,
                            'idGroup' => 2,
                        ],    
                        3 => [        
                            'idTeam1' => 5,
                            'idTeam2' => 9,
                            'goalTeam1' => 0,
                            'goalTeam2' => 1,
                            'idGroup' => 3,
                        ],    
                        4 => [        
                            'idTeam1' => 8,
                            'idTeam2' => 11,
                            'goalTeam1' => 1,
                            'goalTeam2' => 0,
                            'idGroup' => 4,
                        ],    
                    ],        
                    2 => [    
                        1 => [        
                            'idTeam1' => 15,
                            'idTeam2' => 12,
                            'goalTeam1' => 1,
                            'goalTeam2' => 0,
                            'idGroup' => 1,
                        ],    
                        2 => [        
                            'idTeam1' => 9,
                            'idTeam2' => 8,
                            'goalTeam1' => 0,
                            'goalTeam2' => 1,
                            'idGroup' => 2,
                        ],    
                    ],        
                    3 => [    
                        1 => [        
                            'idTeam1' => 15,
                            'idTeam2' => 8,
                            'goalTeam1' => 0,
                            'goalTeam2' => 1,
                            'idGroup' => 1,
                        ],    
                        2 => [        
                            'idTeam1' => 12,
                            'idTeam2' => 9,
                            'goalTeam1' => 1,
                            'goalTeam2' => 0,
                            'idGroup' => 2,
                        ],    
                    ]        
                ],
                [    
                    1 => [        
                        'idTeam1' => 15,
                        'idTeam2' => 8,
                        'goalTeam1' => 0,
                        'goalTeam2' => 1,
                        'idGroup' => 1,
                    ],    
                    2 => [        
                        'idTeam1' => 12,
                        'idTeam2' => 9,
                        'goalTeam1' => 1,
                        'goalTeam2' => 0,
                        'idGroup' => 2,
                    ],    
                ]
            ],           
        ];
    }  
    
    public function winnersDataProvider()
    {
        return [
            [
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
                        'idTeam' => 12,
                        'position' => 3,
                    ],    
                    4 => [    
                        'idTeam' => 6,
                        'position' => 4,
                    ],    
                ]
            ],           
        ];
    } 
    
    public function teamsNamesDataProvider()
    {
        return [
            [
                [
                    1 => [    
                        'idTeam' => 1,
                        'teamName' => 'A (Division A)',
                    ],    
                    2 => [    
                        'idTeam' => 2,
                        'teamName' => 'B (Division A)',
                    ],    
                ]
            ],           
        ];
    }    
}
