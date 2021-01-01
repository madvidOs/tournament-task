<?php

namespace Tests\Unit\Tournament\PlayoffLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoAggregator as DivisionsInfoAggregator;
use App\Src\Tournament\Services\PlayoffLogic\InfoAggregator;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBPreparation;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\EntitiesGenerator;
use App\Src\Tournament\Services\PlayoffLogic\InfoBuilder;
use PHPUnit\Framework\TestCase;

class InfoBuilderTest extends TestCase
{
    private $divisionsInfoAggregatorMock;
    private $dataDBProxyMock;
    private $entitiesGeneratorMock;
    private $dataDBPreparationMock;
    private $infoAggregatorMock;


    /**
     * Set up mocks
     *     
     * @return void
     */
    protected function setUp(): void
    {
        $this->divisionsInfoAggregatorMock = $this->getMockBuilder(DivisionsInfoAggregator::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'getPositionsInDivisions',
                    'getAllTeams',
                    'getDivisions'
                ]
            )->getMock();

        $this->dataDBProxyMock = $this->getMockBuilder(DataDBProxy::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'insertBracket',
                    'insertParticipants',
                    'insertGames',
                    'insertWinners',
                ]
            )->getMock();

        $this->entitiesGeneratorMock = $this->getMockBuilder(EntitiesGenerator::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'getParticipants',
                    'getLevel1Bracket',
                    'getLevel2Bracket',
                    'getLevel3Bracket',
                    'getWinners',
                    'getTeamsNames',
                    'createGamesResults',
                ]
            )->getMock();

        $this->dataDBPreparationMock = $this->getMockBuilder(DataDBPreparation::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'getBracketDataForInsert',
                    'getParticipantsDataForInsert',
                    'getGamesDataForInsert',
                    'getWinnersDataForInsert',
                ]
            )->getMock();


        $this->infoAggregatorMock = $this->getMockBuilder(InfoAggregator::class)
            ->onlyMethods(
                [
                    'setParticipants',
                    'getParticipants',
                    'setBracket',
                    'getBracket',
                    'setGames',
                    'getGames',
                    'getWinnersGames',
                    'setWinners',
                    'getWinners',
                    'setTeamsNames'
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
            $this->dataDBPreparationMock,
            $this->dataDBProxyMock,
            $this->divisionsInfoAggregatorMock,
            $this->entitiesGeneratorMock,
            $this->infoAggregatorMock
        );
    }

    /**
     * Test setUpParticipants method
     *
     * @return void
     */
    public function testSetUpParticipants()
    {
        $infoBuilder = new InfoBuilder(
            $this->divisionsInfoAggregatorMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->divisionsInfoAggregatorMock->expects($this->once())
            ->method('getPositionsInDivisions')
            ->willReturn([]);

        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getParticipants')
            ->willReturn([]);

        $this->infoAggregatorMock->expects($this->once())
            ->method('setParticipants');

        $infoBuilder->setUpParticipants();
    }

    /**
     * Test setUpBracket method     
     *
     * @return void
     */
    public function testSetUpBracket()
    {
        $infoBuilder = new InfoBuilder(
            $this->divisionsInfoAggregatorMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->infoAggregatorMock->expects($this->once())
            ->method('getParticipants')
            ->willReturn([]);

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

        $this->infoAggregatorMock->expects($this->once())
            ->method('setBracket');

        $this->infoAggregatorMock->expects($this->once())
            ->method('setGames');

        $infoBuilder->setUpBracket();
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
        $infoBuilder = new InfoBuilder(
            $this->divisionsInfoAggregatorMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->infoAggregatorMock->expects($this->once())
            ->method('getWinnersGames')
            ->willReturn([]);

        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getWinners')
            ->willReturn([]);

        $this->infoAggregatorMock->expects($this->once())
            ->method('setWinners');

        $infoBuilder->setUpWinners();
    }

    /**
     * Test setUpTeamsNames method
     *
     * @return void
     */
    public function testSetUpTeamsNames()
    {
        $infoBuilder = new InfoBuilder(
            $this->divisionsInfoAggregatorMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->divisionsInfoAggregatorMock->expects($this->once())
            ->method('getAllTeams')
            ->willReturn([]);

        $this->divisionsInfoAggregatorMock->expects($this->once())
            ->method('getDivisions')
            ->willReturn([]);

        $this->entitiesGeneratorMock->expects($this->once())
            ->method('getTeamsNames')
            ->willReturn([]);

        $this->infoAggregatorMock->expects($this->once())
            ->method('setTeamsNames');

        $infoBuilder->setUpTeamsNames();
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
        $infoBuilder = new InfoBuilder(
            $this->divisionsInfoAggregatorMock,
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->infoAggregatorMock->expects($this->once())
            ->method('getParticipants')
            ->willReturn([]);

        $this->dataDBPreparationMock->expects($this->once())
            ->method('getParticipantsDataForInsert')
            ->willReturn([]);

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertParticipants');

        $this->infoAggregatorMock->expects($this->once())
            ->method('getBracket')
            ->willReturn([]);

        $this->dataDBPreparationMock->expects($this->once())
            ->method('getBracketDataForInsert')
            ->willReturn([]);

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertBracket');

        $this->infoAggregatorMock->expects($this->once())
            ->method('getGames')
            ->willReturn([]);

        $this->dataDBPreparationMock->expects($this->once())
            ->method('getGamesDataForInsert')
            ->willReturn([]);

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertGames');

        $this->infoAggregatorMock->expects($this->once())
            ->method('getWinners')
            ->willReturn([]);

        $this->dataDBPreparationMock->expects($this->once())
            ->method('getWinnersDataForInsert')
            ->willReturn([]);

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertWinners');

        $infoBuilder->writeDataToDB();
    }
}
