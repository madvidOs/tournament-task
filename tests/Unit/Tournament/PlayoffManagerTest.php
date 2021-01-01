<?php

namespace Tests\Unit\Tournament;

use App\Src\Tournament\Services\PlayoffLogic\InfoAggregator;
use App\Src\Tournament\Services\PlayoffLogic\InfoBuilder;
use App\Src\Tournament\Services\PlayoffManager;
use PHPUnit\Framework\TestCase;

class PlayoffManagerTest extends TestCase
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
                    'setUpParticipants',
                    'setUpBracket',
                    'setUpWinners',
                    'setUpTeamsNames',
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
        parent::tearDown();
        unset(
            $this->infoAggregatorMock,
            $this->infoBuilderMock
        );
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
            ->method('setUpParticipants');

        $infoBuilderMock->expects($this->once())
            ->method('setUpBracket');

        $infoBuilderMock->expects($this->once())
            ->method('setUpWinners');

        $infoBuilderMock->expects($this->once())
            ->method('setUpTeamsNames');

        $infoBuilderMock->expects($this->once())
            ->method('writeDataToDB');

        $infoBuilderMock->expects($this->once())
            ->method('getInfoAggregator')
            ->willReturn($infoAggregatorMock);

        $infoAggregatorMock->expects($this->once())
            ->method('toArray')
            ->with($this->equalTo(['bracket', 'games', 'winners', 'teamsNames']));

        $playoffManager = new PlayoffManager($infoBuilderMock);
        $playoffManager->getGamesResults();
    }
}
