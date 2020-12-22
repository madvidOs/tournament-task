<?php

namespace Tests\Unit\Tournament\PlayoffLogic;

use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBPreparation;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBProxy;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffEntitiesGenerator;
use App\Library\Services\Tournament\PlayoffLogic\PlayoffInfo;
use PHPUnit\Framework\TestCase;

class PlayoffInfoTest extends TestCase
{
    private $divisionsInfoStub;
    private $playoffDataDBProxyStub;
    private $playoffEntitiesGeneratorStub;
    private $playoffDataDBPreparationStub;
    

    protected function setUp(): void
    {        
        $this->divisionsInfoStub = $this->getMockBuilder(DivisionsInfo::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getPositions',
                'getAllTeams',                
                'getDivisions',                
            ])->getMock();

        $this->playoffDataDBProxyStub = $this->getMockBuilder(PlayoffDataDBProxy::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'insertBracket',
                'insertParticipants',                
                'insertGames',                
                'insertWinners',                
            ])->getMock();

        $this->playoffEntitiesGeneratorStub = $this->getMockBuilder(PlayoffEntitiesGenerator::class)
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
            
        $this->playoffDataDBPreparationStub = $this->getMockBuilder(PlayoffDataDBPreparation::class)
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
        $this->divisionsInfoStub->expects($this->once())
            ->method('getPositions')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub->expects($this->once())
            ->method('getParticipants')
            ->willReturn([]);    
        
        $playInfo = new PlayoffInfo(
            $this->divisionsInfoStub,
            $this->playoffDataDBProxyStub,
            $this->playoffEntitiesGeneratorStub,
            $this->playoffDataDBPreparationStub
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
        $this->divisionsInfoStub
            ->method('getPositions')
            ->willReturn([]); 
            
        $this->playoffEntitiesGeneratorStub
            ->method('getParticipants')
            ->willReturn([]);      
        
        $playInfo = new PlayoffInfo(
            $this->divisionsInfoStub,
            $this->playoffDataDBProxyStub,
            $this->playoffEntitiesGeneratorStub,
            $this->playoffDataDBPreparationStub
        );
        $playInfo->setUpParticipants();

        //start test

        $this->playoffEntitiesGeneratorStub->expects($this->once())
            ->method('getLevel1Bracket')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub->expects($this->once())
            ->method('getLevel2Bracket')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub->expects($this->once())
            ->method('getLevel3Bracket')
            ->willReturn([]);

        $this->playoffEntitiesGeneratorStub->expects($this->exactly(3))
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
        $this->divisionsInfoStub
            ->method('getPositions')
            ->willReturn([]); 
            
        $this->playoffEntitiesGeneratorStub
            ->method('getParticipants')
            ->willReturn([]);      
        
        $playInfo = new PlayoffInfo(
            $this->divisionsInfoStub,
            $this->playoffDataDBProxyStub,
            $this->playoffEntitiesGeneratorStub,
            $this->playoffDataDBPreparationStub
        );
        $playInfo->setUpParticipants();        

        $this->playoffEntitiesGeneratorStub
            ->method('getLevel1Bracket')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub
            ->method('getLevel2Bracket')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub
            ->method('getLevel3Bracket')
            ->willReturn([]);

        $this->playoffEntitiesGeneratorStub
            ->method('createGamesResults')
            ->willReturn([]);

        $playInfo->setUpBracket();

        //start test
        $this->playoffEntitiesGeneratorStub->expects($this->once())
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
        $this->divisionsInfoStub->expects($this->once())
            ->method('getAllTeams')
            ->willReturn([]);

        $this->divisionsInfoStub->expects($this->once())
            ->method('getDivisions')
            ->willReturn([]);    
            
        $this->playoffEntitiesGeneratorStub->expects($this->once())
            ->method('getTeamsNames')
            ->willReturn([]);    
        
        $playInfo = new PlayoffInfo(
            $this->divisionsInfoStub,
            $this->playoffDataDBProxyStub,
            $this->playoffEntitiesGeneratorStub,
            $this->playoffDataDBPreparationStub
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
        $this->divisionsInfoStub
            ->method('getPositions')
            ->willReturn([]); 
            
        $this->playoffEntitiesGeneratorStub
            ->method('getParticipants')
            ->willReturn([]);      
        
        $playInfo = new PlayoffInfo(
            $this->divisionsInfoStub,
            $this->playoffDataDBProxyStub,
            $this->playoffEntitiesGeneratorStub,
            $this->playoffDataDBPreparationStub
        );
        $playInfo->setUpParticipants();        

        $this->playoffEntitiesGeneratorStub
            ->method('getLevel1Bracket')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub
            ->method('getLevel2Bracket')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub
            ->method('getLevel3Bracket')
            ->willReturn([]);

        $this->playoffEntitiesGeneratorStub
            ->method('createGamesResults')
            ->willReturn([]);

        $playInfo->setUpBracket();
        
        $this->playoffEntitiesGeneratorStub
            ->method('getWinners')
            ->willReturn([]);

        $playInfo->setUpWinners();    

        //start test
        $this->playoffDataDBProxyStub->expects($this->once())
            ->method('insertParticipants');
        
        $this->playoffDataDBProxyStub->expects($this->once())
            ->method('insertBracket');    

        $this->playoffDataDBProxyStub->expects($this->once())
            ->method('insertGames');   
            
        $this->playoffDataDBProxyStub->expects($this->once())
            ->method('insertWinners');  
                    
        $this->playoffDataDBPreparationStub->expects($this->once())
            ->method('getParticipantsDataForInsert')
            ->willReturn([]);
            
        $this->playoffDataDBPreparationStub->expects($this->once())
            ->method('getBracketDataForInsert')
            ->willReturn([]);    

        $this->playoffDataDBPreparationStub->expects($this->once())
            ->method('getGamesDataForInsert')
            ->willReturn([]);        

        $this->playoffDataDBPreparationStub->expects($this->once())
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
        $this->divisionsInfoStub
            ->method('getPositions')
            ->willReturn([]); 
            
        $this->playoffEntitiesGeneratorStub
            ->method('getParticipants')
            ->willReturn([]);      
        
        $playInfo = new PlayoffInfo(
            $this->divisionsInfoStub,
            $this->playoffDataDBProxyStub,
            $this->playoffEntitiesGeneratorStub,
            $this->playoffDataDBPreparationStub
        );
        $playInfo->setUpParticipants();        

        $this->playoffEntitiesGeneratorStub
            ->method('getLevel1Bracket')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub
            ->method('getLevel2Bracket')
            ->willReturn([]);
            
        $this->playoffEntitiesGeneratorStub
            ->method('getLevel3Bracket')
            ->willReturn([]);

        $this->playoffEntitiesGeneratorStub
            ->method('createGamesResults')
            ->willReturn([]);

        $playInfo->setUpBracket();
        
        $this->playoffEntitiesGeneratorStub
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
