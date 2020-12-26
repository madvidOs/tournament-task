<?php

namespace Tests\Unit\Tournament\PlayoffLogic\Instruments;

use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBPreparation;
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
     * Test getBracketDataForInsert method
     * 
     * @dataProvider bracketDataProvider
     *
     * @return void
     */
    public function testGetBracketDataForInsert(array $bracket, array $result)
    {
        $cook = new DataDBPreparation;
        $insert = $cook->getBracketDataForInsert($bracket);                

        $this->assertEquals($insert, $result);        
    }   

    /**
     * Test getParticipantsDataForInsert method
     * 
     * @dataProvider participantsDataProvider
     *
     * @return void
     */
    public function testGetParticipantsDataForInsert(array $participants, array $result)
    {
        $cook = new DataDBPreparation;
        $insert = $cook->getParticipantsDataForInsert($participants);                

        $this->assertEquals($insert, $result);        
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
     * Test getWinnersDataForInsert method
     * 
     * @dataProvider winnersDataProvider
     *
     * @return void
     */
    public function testGetWinnersDataForInsert(array $winners, array $result)
    {
        $cook = new DataDBPreparation;
        $insert = $cook->getWinnersDataForInsert($winners);        

        $this->assertEquals($insert, $result);        
    } 


    public function bracketDataProvider()
    {
        return [
            [
                [
                    1 => [    
                        0 => [        
                            'idTeam' => 1,
                            'idGroup' => 4,
                            'level' => 1,
                        ],    
                        1 => [        
                            'idTeam' => 2,
                            'idGroup' => 3,
                            'level' => 1,
                        ],    
                        2 => [        
                            'idTeam' => 3,
                            'idGroup' => 1,
                            'level' => 1,
                        ],   
                    ],    
                    2 => [    
                        0 => [        
                            'idTeam' => 14,
                            'idGroup' => 1,
                            'level' => 2     ,
                        ],
                    ],       
                    3 => [    
                        0 => [        
                            'idTeam' => 12,
                            'idGroup' => 1,
                            'level' => 3            ,
                        ],
                    ],       
                ],
                [
                    0 => [  
                        'level' => 1,
                        'group_number' => 4,
                        'id_team' => 1,
                    ],  
                    1 => [  
                        'level' => 1,
                        'group_number' => 3,
                        'id_team' => 2,
                    ],  
                    2 => [  
                        'level' => 1,
                        'group_number' => 1,
                        'id_team' => 3,
                    ],  
                    3 => [  
                        'level' => 2,
                        'group_number' => 1,
                        'id_team' => 14,
                    ],   
                    4 => [  
                        'level' => 3,
                        'group_number' => 1,
                        'id_team' => 12,
                    ],   
                ]

            ],           
        ];
    }

    public function participantsDataProvider()
    {
        return [
            [
                [
                    0 => [    
                        'idTeam' => 3,
                        'idDivision' => 1,
                        'position' => 1,
                    ],    
                    1 => [    
                        'idTeam' => 4,
                        'idDivision' => 1,
                        'position' => 2,
                    ],    
                    2 => [    
                        'idTeam' => 5,
                        'idDivision' => 1,
                        'position' => 4,
                    ],    
                ],
                [
                    0 => [    
                        'id_team' => 3,
                        'id_division' => 1,
                        'position' => 1,
                    ],    
                    1 => [    
                        'id_team' => 4,
                        'id_division' => 1,
                        'position' => 2,
                    ],    
                    2 => [    
                        'id_team' => 5,
                        'id_division' => 1,
                        'position' => 4,
                    ],    
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
                            'idTeam1' =>  1,
                            'idTeam2' =>  14,
                            'goalTeam1' =>  0,
                            'goalTeam2' =>  1,
                            'idGroup' =>  1,
                        ],    
                        2 => [        
                            'idTeam1' =>  3,
                            'idTeam2' =>  11,
                            'goalTeam1' =>  0,
                            'goalTeam2' =>  1,
                            'idGroup' =>  2,
                        ] 
                    ],      
                    2 => [    
                        1 => [        
                            'idTeam1' =>  14,
                            'idTeam2' =>  11,
                            'goalTeam1' =>  1,
                            'goalTeam2' =>  0,
                            'idGroup' =>  1,
                        ]
                        ],       
                    3 => [    
                        1 => [        
                            'idTeam1' =>  14,
                            'idTeam2' =>  12,
                            'goalTeam1' =>  1,
                            'goalTeam2' =>  0,
                            'idGroup' =>  1,
                        ]
                    ]       
                ],
                [
                    0 => [  
                        'id_team1' =>  1,
                        'id_team2' => 14,
                        'goal_team1' => 0,
                        'goal_team2' => 1,
                        'id_group' => 1,
                    ],
                    1 => [  
                        'id_team1' =>  3,
                        'id_team2' => 11,
                        'goal_team1' => 0,
                        'goal_team2' => 1,
                        'id_group' => 2,
                    ],
                    2 => [  
                        'id_team1' =>  14,
                        'id_team2' => 11,
                        'goal_team1' => 1,
                        'goal_team2' => 0,
                        'id_group' => 1,
                    ],
                    3 => [  
                        'id_team1' =>  14,
                        'id_team2' => 12,
                        'goal_team1' => 1,
                        'goal_team2' => 0,
                        'id_group' => 1,
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
                        'idTeam' => 14,
                        'position' => 1,
                    ],    
                    2 => [    
                        'idTeam' => 4,
                        'position' => 2,
                    ],    
                    3 => [    
                        'idTeam' => 9,
                        'position' => 3,
                    ],    
                    4 => [    
                        'idTeam' => 16,
                        'position' => 4,
                    ],    
                ],
                [
                    0 => [    
                        'id_team' => 14,
                        'position' => 1,
                    ],    
                    1 => [    
                        'id_team' => 4,
                        'position' => 2,
                    ],    
                    2 => [    
                        'id_team' => 9,
                        'position' => 3,
                    ],    
                    3 => [    
                        'id_team' => 16,
                        'position' => 4,
                    ],    
                ]
            ],           
        ];
    }
    
}
