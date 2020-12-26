<?php

namespace Tests\Unit\Tournament\PlayoffLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder as DivisionsInfoBuilder;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBPreparation;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\EntitiesGenerator;
use App\Src\Tournament\Services\PlayoffLogic\InfoBuilder;
use PHPUnit\Framework\TestCase;

class InfoBuilderTest extends TestCase
{
    private $divisionsInfoBuilderMock;
    private $dataDBProxyMock;
    private $entitiesGeneratorMock;
    private $dataDBPreparationStub;
    

    protected function setUp(): void
    {        
        $this->divisionsInfoBuilderMock = $this->getMockBuilder(DivisionsInfoBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getPositions',
                'getAllTeams',                
                'getDivisions',                
            ])->getMock();

        $this->dataDBProxyMock = $this->getMockBuilder(DataDBProxy::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'insertBracket',
                'insertParticipants',                
                'insertGames',                
                'insertWinners',                
            ])->getMock();

        $this->entitiesGeneratorMock = $this->getMockBuilder(EntitiesGenerator::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getParticipants',
                'getLevel1Bracket',                
                'getLevel2Bracket',                
                'getLevel3Bracket',                
                'getWinners', 
                'getTeamsNames', 
                'createGamesResults', 
            ])->getMock();  
            
        $this->dataDBPreparationStub = $this->getMockBuilder(DataDBPreparation::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getBracketDataForInsert',
                'getParticipantsDataForInsert',                
                'getGamesDataForInsert',                
                'getWinnersDataForInsert',                
            ])->getMock();

        
        
    }

    protected function tearDown():void
    {        
        
    }


    /**
     * Test setUpParticipants method
     *
     * @return void
     */
    public function testSetUpParticipants()
    {        
        $this->divisionsInfoBuilderMock->expects($this->once())
            ->method('getPositions')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getParticipants')
            ->willReturn([]);    
        
        $playInfo = new InfoBuilder(
            $this->divisionsInfoBuilderMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationStub
        );
        $playInfo->setUpParticipants();
    }  
    
    /**
     * Test setUpBracket method
     * 
     * @depends testSetUpParticipants
     *
     * @return void
     */
    public function testSetUpBracket()
    {    
        $this->divisionsInfoBuilderMock
            ->method('getPositions')
            ->willReturn([]); 
            
        $this->entitiesGeneratorMock
            ->method('getParticipants')
            ->willReturn([]);      
        
        $playInfo = new InfoBuilder(
            $this->divisionsInfoBuilderMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationStub
        );
        $playInfo->setUpParticipants();

        //start test

        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getLevel1Bracket')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getLevel2Bracket')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getLevel3Bracket')
            ->willReturn([]);

        $this->entitiesGeneratorMock->expects($this->exactly(3))
            ->method('createGamesResults')
            ->willReturn([]);

        $playInfo->setUpBracket();
    }

    /**
     * Test setUpWinners method
     * 
     * @depends testSetUpBracket
     *
     * @return void
     */
    public function testSetUpWinners()
    {    
        $this->divisionsInfoBuilderMock
            ->method('getPositions')
            ->willReturn([]); 
            
        $this->entitiesGeneratorMock
            ->method('getParticipants')
            ->willReturn([]);      
        
        $playInfo = new InfoBuilder(
            $this->divisionsInfoBuilderMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationStub
        );
        $playInfo->setUpParticipants();        

        $this->entitiesGeneratorMock
            ->method('getLevel1Bracket')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock
            ->method('getLevel2Bracket')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock
            ->method('getLevel3Bracket')
            ->willReturn([]);

        $this->entitiesGeneratorMock
            ->method('createGamesResults')
            ->willReturn([]);

        $playInfo->setUpBracket();

        //start test
        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getWinners')
            ->willReturn([]);

        $playInfo->setUpWinners();    

    }

    /**
     * Test setUpTeamsNames method
     *
     * @return void
     */
    public function testSetUpTeamsNames()
    {        
        $this->divisionsInfoBuilderMock->expects($this->once())
            ->method('getAllTeams')
            ->willReturn([]);

        $this->divisionsInfoBuilderMock->expects($this->once())
            ->method('getDivisions')
            ->willReturn([]);    
            
        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getTeamsNames')
            ->willReturn([]);    
        
        $playInfo = new InfoBuilder(
            $this->divisionsInfoBuilderMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationStub
        );
        $playInfo->setUpTeamsNames();
    }  

    /**
     * Test writeDataToDB method
     * 
     * @depends testSetUpWinners
     *
     * @return void
     */
    public function testWriteDataToDB()
    {    
        $this->divisionsInfoBuilderMock
            ->method('getPositions')
            ->willReturn([]); 
            
        $this->entitiesGeneratorMock
            ->method('getParticipants')
            ->willReturn([]);      
        
        $playInfo = new InfoBuilder(
            $this->divisionsInfoBuilderMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationStub
        );
        $playInfo->setUpParticipants();        

        $this->entitiesGeneratorMock
            ->method('getLevel1Bracket')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock
            ->method('getLevel2Bracket')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock
            ->method('getLevel3Bracket')
            ->willReturn([]);

        $this->entitiesGeneratorMock
            ->method('createGamesResults')
            ->willReturn([]);

        $playInfo->setUpBracket();
        
        $this->entitiesGeneratorMock
            ->method('getWinners')
            ->willReturn([]);

        $playInfo->setUpWinners();    

        //start test
        $this->dataDBProxyMock->expects($this->once())
            ->method('insertParticipants');
        
        $this->dataDBProxyMock->expects($this->once())
            ->method('insertBracket');    

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertGames');   
            
        $this->dataDBProxyMock->expects($this->once())
            ->method('insertWinners');  
                    
        $this->dataDBPreparationStub->expects($this->once())
            ->method('getParticipantsDataForInsert')
            ->willReturn([]);
            
        $this->dataDBPreparationStub->expects($this->once())
            ->method('getBracketDataForInsert')
            ->willReturn([]);    

        $this->dataDBPreparationStub->expects($this->once())
            ->method('getGamesDataForInsert')
            ->willReturn([]);        

        $this->dataDBPreparationStub->expects($this->once())
            ->method('getWinnersDataForInsert')
            ->willReturn([]);            
            
        $playInfo->writeDataToDB();      

    }

    /**
     * Test getResponse method
     * 
     * @depends testSetUpWinners
     *
     * @return void
     */
    public function testGetResponse()
    {    
        $this->divisionsInfoBuilderMock
            ->method('getPositions')
            ->willReturn([]); 
            
        $this->entitiesGeneratorMock
            ->method('getParticipants')
            ->willReturn([]);      
        
        $playInfo = new InfoBuilder(
            $this->divisionsInfoBuilderMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationStub
        );
        $playInfo->setUpParticipants();        

        $this->entitiesGeneratorMock
            ->method('getLevel1Bracket')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock
            ->method('getLevel2Bracket')
            ->willReturn([]);
            
        $this->entitiesGeneratorMock
            ->method('getLevel3Bracket')
            ->willReturn([]);

        $this->entitiesGeneratorMock
            ->method('createGamesResults')
            ->willReturn([]);

        $playInfo->setUpBracket();
        
        $this->entitiesGeneratorMock
            ->method('getWinners')
            ->willReturn([]);

        $playInfo->setUpWinners();    

        //start test
        $response = $playInfo->getResponse([
            'bracket', 
            'games', 
            'winners', 
            'teamNames'
        ]);        

        $this->assertArrayHasKey('playoff', $response);
        $this->assertArrayHasKey('bracket', $response['playoff']);
        $this->assertArrayHasKey('games', $response['playoff']);
        $this->assertArrayHasKey('winners', $response['playoff']);
        $this->assertArrayHasKey('teamNames', $response['playoff']);

    }
    
}
