<?php

namespace Tests\Unit\Tournament;

use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo;
use App\Library\Services\Tournament\DivisionsManager;
use PHPUnit\Framework\TestCase;

class DivisionsManagerTest extends TestCase
{

    protected $divisionsInfoStack;

    protected function setUp(): void
    {        
        $this->divisionsInfoStack = $this->getMockBuilder(DivisionsInfo::class)
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
        $this->divisionsInfoStack->expects($this->once())
            ->method('setUpDivisions');
        
        $this->divisionsInfoStack->expects($this->once())
            ->method('setUpTeams');        

        $this->divisionsInfoStack->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo(['teams']));
        
        $divisionsManager = new DivisionsManager($this->divisionsInfoStack);
        $divisionsManager->getDivisionsWithParticipants();    

    }

    /**
     * Test getGamesResults method
     *
     * @return void
     */
    public function testGetGamesResults()
    {
        $this->divisionsInfoStack->expects($this->once())
            ->method('setUpDivisions');
        
        $this->divisionsInfoStack->expects($this->once())
            ->method('setUpTeams');    

        $this->divisionsInfoStack->expects($this->once())
            ->method('setUpGames');    
        
        $this->divisionsInfoStack->expects($this->once())
            ->method('setUpScore');
        
        $this->divisionsInfoStack->expects($this->once())
            ->method('setUpPositions');    

        $this->divisionsInfoStack->expects($this->once())
            ->method('writeDataToDB');    
        
        $this->divisionsInfoStack->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo(['teams', 'games', 'score', 'positions']));
        
        $divisionsManager = new DivisionsManager($this->divisionsInfoStack);
        $divisionsManager->getGamesResults();    

    }
}
