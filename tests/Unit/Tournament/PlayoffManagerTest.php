<?php

namespace Tests\Unit\Tournament;

use App\Library\Services\Tournament\PlayoffLogic\PlayoffInfo;
use App\Library\Services\Tournament\PlayoffManager;
use PHPUnit\Framework\TestCase;

class PlayoffManagerTest extends TestCase
{
    protected $playoffInfoMock;

    protected function setUp(): void
    {        
        $this->playoffInfoMock = $this->getMockBuilder(PlayoffInfo::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'setUpParticipants',
                'setUpBracket',
                'setUpWinners',
                'setUpTeamsNames',                
                'writeDataToDB',
                'getResponse',
            ])->getMock();
    }

    protected function tearDown():void
    {
        parent::tearDown();     
    }
    

    /**
     * Test getGamesResults method
     *
     * @return void
     */
    public function testGetGamesResults()
    {
        $playoffInfoMock = $this->playoffInfoMock;
        $playoffInfoMock->expects($this->once())
            ->method('setUpParticipants');
        
        $playoffInfoMock->expects($this->once())
            ->method('setUpBracket');    

        $playoffInfoMock->expects($this->once())
            ->method('setUpWinners');    
        
        $playoffInfoMock->expects($this->once())
            ->method('setUpTeamsNames');
        
        $playoffInfoMock->expects($this->once())
            ->method('writeDataToDB');    
        
        $playoffInfoMock->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo(['bracket', 'games', 'winners', 'teamNames']));
        
        $playoffManager = new PlayoffManager($playoffInfoMock);
        $playoffManager->getGamesResults();

    }
}
