<?php

namespace Tests\Unit\Tournament\DivisionsLogic\Instruments;

use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Repositories\DivisionGameRepository;
use App\Src\Tournament\Repositories\DivisionPositionRepository;
use App\Src\Tournament\Repositories\DivisionRepository;
use App\Src\Tournament\Repositories\DivisionTeamRepository;
use PHPUnit\Framework\TestCase;

class DataDBProxyTest extends TestCase
{

    private $divisionRepositoryMock;
    private $divisionTeamRepositoryMock;
    private $divisionGameRepositoryMock;
    private $divisionPositionRepositoryMock;

    /**
     * Set up mocks
     *     
     * @return void
     */
    protected function setUp(): void
    {
        $this->divisionRepositoryMock 
            = $this->getMockBuilder(DivisionRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'all',
                ]
            )->getMock();

        $this->divisionTeamRepositoryMock 
            = $this->getMockBuilder(DivisionTeamRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'all',
                ]
            )->getMock();

        $this->divisionGameRepositoryMock 
            = $this->getMockBuilder(DivisionGameRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'truncate',
                    'insert',
                ]
            )->getMock();

        $this->divisionPositionRepositoryMock 
            = $this->getMockBuilder(DivisionPositionRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'truncate',
                    'insert',
                ]
            )->getMock();
    }

    /**
     * Free mocks
     *     
     * @return void
     */
    protected function tearDown(): void
    {
        unset(
            $this->divisionRepositoryMock,
            $this->divisionTeamRepositoryMock,
            $this->divisionGameRepositoryMock,
            $this->divisionPositionRepositoryMock,
        );
    }


    /**
     * Test getDivisions method     
     *
     * @return void
     */
    public function testGetDivisions()
    {
        $this->divisionRepositoryMock->expects($this->once())
            ->method('all');

        $divisionsDataDBProxy = new DataDBProxy(
            $this->divisionRepositoryMock,
            $this->divisionTeamRepositoryMock,
            $this->divisionGameRepositoryMock,
            $this->divisionPositionRepositoryMock,

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
        $this->divisionTeamRepositoryMock->expects($this->once())
            ->method('all');

        $divisionsDataDBProxy = new DataDBProxy(
            $this->divisionRepositoryMock,
            $this->divisionTeamRepositoryMock,
            $this->divisionGameRepositoryMock,
            $this->divisionPositionRepositoryMock,

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
        $this->divisionGameRepositoryMock->expects($this->once())
            ->method('truncate');

        $this->divisionGameRepositoryMock->expects($this->once())
            ->method('insert');

        $divisionsDataDBProxy = new DataDBProxy(
            $this->divisionRepositoryMock,
            $this->divisionTeamRepositoryMock,
            $this->divisionGameRepositoryMock,
            $this->divisionPositionRepositoryMock,

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
        $this->divisionPositionRepositoryMock->expects($this->once())
            ->method('truncate');

        $this->divisionPositionRepositoryMock->expects($this->once())
            ->method('insert');

        $divisionsDataDBProxy = new DataDBProxy(
            $this->divisionRepositoryMock,
            $this->divisionTeamRepositoryMock,
            $this->divisionGameRepositoryMock,
            $this->divisionPositionRepositoryMock,

        );
        $divisionsDataDBProxy->insertPositions([]);
    }
}
