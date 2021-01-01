<?php

namespace Tests\Unit\Tournament;

use App\Src\Tournament\Services\DivisionsLogic\InfoAggregator;
use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder;
use App\Src\Tournament\Services\DivisionsManager;
use PHPUnit\Framework\TestCase;

class DivisionsManagerTest extends TestCase
{
    protected $infoBuilderMock;
    protected $infoAggregatorMock;

    /**
     * Set up mocks
     *     
     * @return void
     */
    protected function setUp(): void
    {
        $this->infoBuilderMock = $this->getMockBuilder(InfoBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'setUpDivisions',
                    'setUpTeams',
                    'setUpGames',
                    'setUpScore',
                    'setUpPositions',
                    'writeDataToDB',
                    'getInfoAggregator',
                ]
            )->getMock();

        $this->infoAggregatorMock = $this->getMockBuilder(InfoAggregator::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'toArray',
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
    }


    /**
     * Test getDivisionsWithParticipants method
     *
     * @return void
     */
    public function testGetDivisionsWithParticipants()
    {
        $infoBuilderMock = $this->infoBuilderMock;
        $infoAggregatorMock = $this->infoAggregatorMock;

        $infoBuilderMock->expects($this->once())
            ->method('setUpDivisions');

        $infoBuilderMock->expects($this->once())
            ->method('setUpTeams');

        $infoBuilderMock->expects($this->once())
            ->method('getInfoAggregator')
            ->willReturn($infoAggregatorMock);

        $infoAggregatorMock->expects($this->once())
            ->method('toArray')
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
        $infoBuilderMock = $this->infoBuilderMock;
        $infoAggregatorMock = $this->infoAggregatorMock;

        $infoBuilderMock->expects($this->once())
            ->method('setUpDivisions');

        $infoBuilderMock->expects($this->once())
            ->method('setUpTeams');

        $infoBuilderMock->expects($this->once())
            ->method('setUpGames');

        $infoBuilderMock->expects($this->once())
            ->method('setUpScore');

        $infoBuilderMock->expects($this->once())
            ->method('setUpPositions');

        $infoBuilderMock->expects($this->once())
            ->method('writeDataToDB');

        $infoBuilderMock->expects($this->once())
            ->method('getInfoAggregator')
            ->willReturn($infoAggregatorMock);

        $infoAggregatorMock->expects($this->once())
            ->method('toArray')
            ->with($this->equalTo(['teams', 'games', 'score', 'positions']));

        $divisionsManager = new DivisionsManager($this->infoBuilderMock);
        $divisionsManager->getGamesResults();
    }
}
