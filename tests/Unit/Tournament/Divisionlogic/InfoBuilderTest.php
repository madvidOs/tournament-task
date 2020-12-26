<?php

namespace Tests\Unit\Tournament\DivisionsLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBPreparation;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\EntitiesGenerator;
use PHPUnit\Framework\TestCase;

class InfoBuilderTest extends TestCase
{
    private $dataDBProxyMock;
    private $entitiesGeneratorMock;
    private $dataDBPreparationMock;

    private $divisionsEmulatedRows;
    private $teamsEmulatedRows;

    protected function setUp(): void
    {        
        $this->dataDBProxyMock = $this->getMockBuilder(DataDBProxy::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getDivisions',
                'getTeams',
                'insertGames',
                'insertPositions',
            ])->getMock();

        
        $this->entitiesGeneratorMock = $this->getMockBuilder(EntitiesGenerator::class)            
            ->onlyMethods([
                'createGamesResults',
                'countScore',
                'countPositions'
            ])->getMock();
            
        $this->dataDBPreparationMock = $this->getMockBuilder(DataDBPreparation::class)            
            ->onlyMethods([
                'getGamesDataForInsert',
                'getPositionsDataForInsert'                
            ])->getMock();    
        
        $this->divisionsEmulatedRows = [
            new class {
                public $id = 1; 
                public $name = 'A';
            },
            new class {
                public $id = 2; 
                public $name = 'B';
            },                
        ]; 
        
        $this->teamsEmulatedRows = [
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
        ];

    }

    protected function tearDown():void
    {        
        unset(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock
        );
    }


    /**
     * Test setUpDivisions and getDivisions methods
     *
     * @return void
     */
    public function testGetSetUpDivisions()
    {        
        $this->dataDBProxyMock->expects($this->once())
            ->method('getDivisions')
            ->willReturn($this->divisionsEmulatedRows);        
        
        $divisionsInfo = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock
        );
        $divisionsInfo->setUpDivisions();            

        $this->assertEquals($divisionsInfo->getDivisions(), [
            1 => [
                "divisionId" => 1,
                "divisionName" => "A"
            ],
            2 => [
                "divisionId" => 2,
                "divisionName" => "B"
            ]
        ]);

    }

    /**
     * Test setUpTeams, getAllTeams, getTeamsByDivision methods
     * 
     * @depends testGetSetUpDivisions
     *
     * @return void
     */
    public function testGetSetUpTeams()
    {      
        $this->dataDBProxyMock
            ->method('getDivisions')
            ->willReturn($this->divisionsEmulatedRows);  

        $divisionsInfo = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock
        );
        $divisionsInfo->setUpDivisions();

        //start test
        $this->dataDBProxyMock->expects($this->once())
            ->method('getTeams')
            ->willReturn($this->teamsEmulatedRows);

        $divisionsInfo->setUpTeams();
        
        $allTeams = $divisionsInfo->getAllTeams();        
        $this->assertCount(16, $allTeams);
        $this->assertArrayHasKey('teamId', $allTeams[1]);
        $this->assertArrayHasKey('divisionId', $allTeams[1]);
        $this->assertArrayHasKey('teamName', $allTeams[1]);

        $teamsByDivision = $divisionsInfo->getTeamsByDivision();        
        $this->assertCount(2, $teamsByDivision);
        $this->assertArrayHasKey('teamId', $teamsByDivision[1][1]);
        $this->assertArrayHasKey('divisionId', $teamsByDivision[1][1]);
        $this->assertArrayHasKey('teamName', $teamsByDivision[1][1]);
    }


    /**
     * Test setUpGames and getGamesByDivision methods
     * 
     * @depends testGetSetUpTeams
     *
     * @return void
     */
    public function testGetSetUpGames()
    {        
        $this->dataDBProxyMock
            ->method('getDivisions')
            ->willReturn($this->divisionsEmulatedRows);  

        $divisionsInfo = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock
        );
        $divisionsInfo->setUpDivisions();

        $this->dataDBProxyMock
            ->method('getTeams')
            ->willReturn($this->teamsEmulatedRows);

        $divisionsInfo->setUpTeams();

        //start test
        $this->entitiesGeneratorMock->expects($this->exactly(2))
            ->method('createGamesResults')
            ->willReturn([]);
        
        $divisionsInfo->setUpGames();       

        $games = $divisionsInfo->getGamesByDivision();  
        $this->assertCount(2, $games);

    }

    /**
     * Test setUpScore and getScore methods
     * 
     * @depends testGetSetUpGames
     *
     * @return void
     */
    public function testGetSetUpScore()
    {        
        $this->dataDBProxyMock
            ->method('getDivisions')
            ->willReturn($this->divisionsEmulatedRows);  

        $divisionsInfo = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock
        );
        $divisionsInfo->setUpDivisions();

        $this->dataDBProxyMock
            ->method('getTeams')
            ->willReturn($this->teamsEmulatedRows);

        $divisionsInfo->setUpTeams();
        
        $this->entitiesGeneratorMock
            ->method('createGamesResults')
            ->willReturn([]);
        
        $divisionsInfo->setUpGames();        

        //start test
        $this->entitiesGeneratorMock->expects($this->exactly(2))
            ->method('countScore')
            ->willReturn([]);

        $divisionsInfo->setUpScore();       

        $score = $divisionsInfo->getScore();  
        $this->assertCount(2, $score);
    }

    /**
     * Test setUpPositions and getPositions methods
     * 
     * @depends testGetSetUpScore
     *
     * @return void
     */
    public function testGetSetUpPositions()
    {        
        $this->dataDBProxyMock
            ->method('getDivisions')
            ->willReturn($this->divisionsEmulatedRows);  

        $divisionsInfo = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock
        );
        $divisionsInfo->setUpDivisions();

        $this->dataDBProxyMock
            ->method('getTeams')
            ->willReturn($this->teamsEmulatedRows);

        $divisionsInfo->setUpTeams();
        
        $this->entitiesGeneratorMock
            ->method('createGamesResults')
            ->willReturn([]);
        
        $divisionsInfo->setUpGames();
        
        $this->entitiesGeneratorMock
            ->method('countScore')
            ->willReturn([]);

        $divisionsInfo->setUpScore();

        //start test
        $this->entitiesGeneratorMock->expects($this->exactly(2))
            ->method('countPositions')
            ->willReturn([]);

        $divisionsInfo->setUpPositions();       

        $positions = $divisionsInfo->getPositions();  
        $this->assertCount(2, $positions);
    }

    /**
     * Test writeDataToDB method
     * 
     * @depends testGetSetUpPositions
     *
     * @return void
     */
    public function testWriteDataToDB()
    {        
        $this->dataDBProxyMock
            ->method('getDivisions')
            ->willReturn($this->divisionsEmulatedRows);  

        $divisionsInfo = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock
        );
        $divisionsInfo->setUpDivisions();

        $this->dataDBProxyMock
            ->method('getTeams')
            ->willReturn($this->teamsEmulatedRows);

        $divisionsInfo->setUpTeams();
        
        $this->entitiesGeneratorMock
            ->method('createGamesResults')
            ->willReturn([]);
        
        $divisionsInfo->setUpGames();
        
        $this->entitiesGeneratorMock
            ->method('countScore')
            ->willReturn([]);

        $divisionsInfo->setUpScore();
        
        $this->entitiesGeneratorMock
            ->method('countPositions')
            ->willReturn([]);

        $divisionsInfo->setUpPositions();

        //start test        
        $this->dataDBPreparationMock->expects($this->once())
            ->method('getGamesDataForInsert')
            ->willReturn([]);

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertGames');
            
        
        $this->dataDBPreparationMock->expects($this->once())
            ->method('getPositionsDataForInsert')
            ->willReturn([]);    

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertPositions');    

        $divisionsInfo->writeDataToDB(); 
        
    }

    /**
     * Test getResponse method
     * 
     * @depends testGetSetUpPositions
     *
     * @return void
     */
    public function testGetResponse()
    {        
        $this->dataDBProxyMock
            ->method('getDivisions')
            ->willReturn($this->divisionsEmulatedRows);  

        $divisionsInfo = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock
        );
        $divisionsInfo->setUpDivisions();

        $this->dataDBProxyMock
            ->method('getTeams')
            ->willReturn($this->teamsEmulatedRows);

        $divisionsInfo->setUpTeams();
        
        $this->entitiesGeneratorMock
            ->method('createGamesResults')
            ->willReturn([]);
        
        $divisionsInfo->setUpGames();
        
        $this->entitiesGeneratorMock
            ->method('countScore')
            ->willReturn([]);

        $divisionsInfo->setUpScore();
        
        $this->entitiesGeneratorMock
            ->method('countPositions')
            ->willReturn([]);

        $divisionsInfo->setUpPositions();    
        
        $response = $divisionsInfo->getResponse([
            'teams', 
            'games', 
            'score', 
            'positions'
        ]);

        //var_dump($response);

        $this->assertArrayHasKey('divisions', $response);
        $this->assertArrayHasKey('divisionId', $response['divisions'][1]);
        $this->assertArrayHasKey('divisionName', $response['divisions'][1]);
        $this->assertArrayHasKey('teams', $response['divisions'][1]);
        $this->assertArrayHasKey('games', $response['divisions'][1]);
        $this->assertArrayHasKey('score', $response['divisions'][1]);
        $this->assertArrayHasKey('positions', $response['divisions'][1]);        
    }
    
}
