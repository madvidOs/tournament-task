<?php

namespace Tests\Unit\Tournament\DivisionsLogic\Instruments;

use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsDataDBProxy;
use App\Repositories\Tournament\DivisionGameRepository;
use App\Repositories\Tournament\DivisionPositionRepository;
use App\Repositories\Tournament\DivisionRepository;
use App\Repositories\Tournament\DivisionTeamRepository;
use PHPUnit\Framework\TestCase;

class DivisionsDataDBProxyTest extends TestCase
{

    private $divisionRepositoryStub;
    private $divisionTeamRepositoryStub;
    private $divisionGameRepositoryStub;
    private $divisionPositionRepositoryStub;

    protected function setUp(): void
    {        
        $this->divisionRepositoryStub = $this->getMockBuilder(DivisionRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'all',                
            ])->getMock();

        $this->divisionTeamRepositoryStub = $this->getMockBuilder(DivisionTeamRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'all',                
            ])->getMock();  
            
        $this->divisionGameRepositoryStub = $this->getMockBuilder(DivisionGameRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'truncate',
                'insert',
            ])->getMock();

        $this->divisionPositionRepositoryStub = $this->getMockBuilder(DivisionPositionRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'truncate',
                'insert',
            ])->getMock();    
    }

    protected function tearDown():void
    {       
        
    }


    /**
     * Test getDivisions method     
     *
     * @return void
     */
    public function testGetDivisions()
    {
        $this->divisionRepositoryStub->expects($this->once())
            ->method('all');            
        
        $divisionsDataDBProxy = new DivisionsDataDBProxy(
            $this->divisionRepositoryStub,
            $this->divisionTeamRepositoryStub,
            $this->divisionGameRepositoryStub,
            $this->divisionPositionRepositoryStub,

        );
        $divisionsDataDBProxy->getDivisions();
        
    }

    /**
     * Test getTeams method     
     *
     * @return void
     */
    public function testGetTeams()
    {
        $this->divisionTeamRepositoryStub->expects($this->once())
            ->method('all');            
        
        $divisionsDataDBProxy = new DivisionsDataDBProxy(
            $this->divisionRepositoryStub,
            $this->divisionTeamRepositoryStub,
            $this->divisionGameRepositoryStub,
            $this->divisionPositionRepositoryStub,

        );
        $divisionsDataDBProxy->getTeams();
        
    }

    /**
     * Test insertGames method     
     *
     * @return void
     */
    public function testInsertGames()
    {
        $this->divisionGameRepositoryStub->expects($this->once())
            ->method('truncate');
            
        $this->divisionGameRepositoryStub->expects($this->once())
            ->method('insert');    
        
        $divisionsDataDBProxy = new DivisionsDataDBProxy(
            $this->divisionRepositoryStub,
            $this->divisionTeamRepositoryStub,
            $this->divisionGameRepositoryStub,
            $this->divisionPositionRepositoryStub,

        );
        $divisionsDataDBProxy->insertGames([]);
        
    }

    /**
     * Test insertPositions method     
     *
     * @return void
     */
    public function testInsertPositions()
    {
        $this->divisionPositionRepositoryStub->expects($this->once())
            ->method('truncate');
            
        $this->divisionPositionRepositoryStub->expects($this->once())
            ->method('insert');    
        
        $divisionsDataDBProxy = new DivisionsDataDBProxy(
            $this->divisionRepositoryStub,
            $this->divisionTeamRepositoryStub,
            $this->divisionGameRepositoryStub,
            $this->divisionPositionRepositoryStub,

        );
        $divisionsDataDBProxy->insertPositions([]);
        
    }

    
}
