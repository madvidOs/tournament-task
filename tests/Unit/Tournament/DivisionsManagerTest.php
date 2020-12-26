<?php

namespace Tests\Unit\Tournament;

use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder;
use App\Src\Tournament\Services\DivisionsManager;
use PHPUnit\Framework\TestCase;

class DivisionsManagerTest extends TestCase
{

    protected $infoBuilderMock;

    protected function setUp(): void
    {        
        $this->infoBuilderMock = $this->getMockBuilder(InfoBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'setUpDivisions',
                'setUpTeams',
                'setUpGames',
                'setUpScore',
                'setUpPositions',
                'writeDataToDB',
                'getResponse',
            ])->getMock();
    }

    protected function tearDown():void
    {
        
    }


    /**
     * Test getDivisionsWithParticipants method
     *
     * @return void
     */
    public function testGetDivisionsWithParticipants()
    {        
        $this->infoBuilderMock->expects($this->once())
            ->method('setUpDivisions');
        
        $this->infoBuilderMock->expects($this->once())
            ->method('setUpTeams');        

        $this->infoBuilderMock->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo(['teams']));
        
        $divisionsManager = new DivisionsManager($this->infoBuilderMock);
        $divisionsManager->getDivisionsWithParticipants();    

    }

    /**
     * Test getGamesResults method
     *
     * @return void
     */
    public function testGetGamesResults()
    {
        $this->infoBuilderMock->expects($this->once())
            ->method('setUpDivisions');
        
        $this->infoBuilderMock->expects($this->once())
            ->method('setUpTeams');    

        $this->infoBuilderMock->expects($this->once())
            ->method('setUpGames');    
        
        $this->infoBuilderMock->expects($this->once())
            ->method('setUpScore');
        
        $this->infoBuilderMock->expects($this->once())
            ->method('setUpPositions');    

        $this->infoBuilderMock->expects($this->once())
            ->method('writeDataToDB');    
        
        $this->infoBuilderMock->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo(['teams', 'games', 'score', 'positions']));
        
        $divisionsManager = new DivisionsManager($this->infoBuilderMock);
        $divisionsManager->getGamesResults();    

    }
}
