<?php

namespace Tests\Unit\Tournament\DivisionsLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoAggregator;
use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBPreparation;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\EntitiesGenerator;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class InfoBuilderTest extends TestCase
{
    private $dataDBProxyMock;
    private $entitiesGeneratorMock;
    private $dataDBPreparationMock;
    private $infoAggregatorMock;

    private $divisions;

    /**
     * Set up mocks
     *     
     * @return void
     */
    protected function setUp(): void
    {
        $this->dataDBProxyMock = $this->getMockBuilder(DataDBProxy::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'getDivisions',
                    'getTeams',
                    'insertGames',
                    'insertPositions',
                ]
            )->getMock();


        $this->entitiesGeneratorMock 
            = $this->getMockBuilder(EntitiesGenerator::class)
            ->onlyMethods(
                [
                    'createGamesResults',
                    'countScore',
                    'countPositions'
                ]
            )->getMock();

        $this->dataDBPreparationMock 
            = $this->getMockBuilder(DataDBPreparation::class)
            ->onlyMethods(
                [
                    'getGamesDataForInsert',
                    'getPositionsDataForInsert'
                ]
            )->getMock();

        $this->infoAggregatorMock = $this->getMockBuilder(InfoAggregator::class)
            ->onlyMethods(
                [
                    'setDivisions',
                    'setTeams',
                    'getDivisions',
                    'getTeamsByDivisionId',
                    'setGamesByDivisionId',
                    'getGamesByDivisionId',
                    'setScoreByDivisionId',
                    'getScoreByDivisionId',
                    'setPositionsByDivisionId',
                    'getGamesInDivisions',
                    'getScoreInDivisions',
                    'getPositionsInDivisions'
                ]
            )->getMock();

        $this->divisions = [
            1 => [
                'divisionId' => 1,
                'divisionName' => 'A'
            ],
            2 => [
                'divisionId' => 2,
                'divisionName' => 'B'
            ]
        ];
    }

    /**
     * Free mocks
     *     
     * @return void
     */
    protected function tearDown(): void
    {
        unset(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );
    }

    /**
     * Test setUpDivisions method
     *
     * @return void
     */
    public function testSetUpDivisions()
    {
        $infoBuilder = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $divisionsMock = $this->getMockBuilder(Collection::class)
            ->onlyMethods(
                [
                    'all',
                ]
            )->getMock();

        $divisionsMock->expects($this->once())
            ->method('all')
            ->willReturn([]);

        $this->dataDBProxyMock->expects($this->once())
            ->method('getDivisions')
            ->willReturn($divisionsMock);

        $this->infoAggregatorMock->expects($this->once())
            ->method('setDivisions');

        $infoBuilder->setUpDivisions();
    }


    /**
     * Test setUpTeams method
     * 
     *
     * @return void
     */
    public function testSetUpTeams()
    {
        $infoBuilder = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $teamsMock = $this->getMockBuilder(Collection::class)
            ->onlyMethods(
                [
                    'all',
                ]
            )->getMock();

        $teamsMock->expects($this->once())
            ->method('all')
            ->willReturn([]);

        $this->dataDBProxyMock
            ->method('getTeams')
            ->willReturn($teamsMock);

        $infoBuilder->setUpTeams();
    }


    /**
     * Test setUpGames method     
     *
     * @return void
     */
    public function testSetUpGames()
    {
        $infoBuilder = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->infoAggregatorMock->expects($this->once())
            ->method('getDivisions')
            ->willReturn($this->divisions);

        $this->infoAggregatorMock->expects($this->exactly(2))
            ->method('getTeamsByDivisionId')
            ->willReturn([]);

        $this->infoAggregatorMock->expects($this->exactly(2))
            ->method('setGamesByDivisionId')
            ->willReturn([]);

        $this->entitiesGeneratorMock->expects($this->exactly(2))
            ->method('createGamesResults')
            ->willReturn([]);

        $infoBuilder->setUpGames();
    }

    /**
     * Test setUpScore method     
     *
     * @return void
     */
    public function testSetUpScore()
    {
        $infoBuilder = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->infoAggregatorMock->expects($this->once())
            ->method('getDivisions')
            ->willReturn($this->divisions);

        $this->infoAggregatorMock->expects($this->exactly(2))
            ->method('getGamesByDivisionId')
            ->willReturn([]);

        $this->infoAggregatorMock->expects($this->exactly(2))
            ->method('setScoreByDivisionId')
            ->willReturn([]);

        $this->entitiesGeneratorMock->expects($this->exactly(2))
            ->method('countScore')
            ->willReturn([]);

        $infoBuilder->setUpScore();
    }

    /**
     * Test setUpPositions method     
     *
     * @return void
     */
    public function testSetUpPositions()
    {
        $infoBuilder = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->infoAggregatorMock->expects($this->once())
            ->method('getDivisions')
            ->willReturn($this->divisions);

        $this->infoAggregatorMock->expects($this->exactly(2))
            ->method('getScoreByDivisionId')
            ->willReturn([]);

        $this->infoAggregatorMock->expects($this->exactly(2))
            ->method('setPositionsByDivisionId')
            ->willReturn([]);

        $this->entitiesGeneratorMock->expects($this->exactly(2))
            ->method('countPositions')
            ->willReturn([]);

        $infoBuilder->setUpPositions();
    }

    /**
     * Test writeDataToDB method
     *
     * @return void
     */
    public function testWriteDataToDB()
    {
        $infoBuilder = new InfoBuilder(
            $this->dataDBProxyMock,
            $this->entitiesGeneratorMock,
            $this->dataDBPreparationMock,
            $this->infoAggregatorMock
        );

        $this->infoAggregatorMock->expects($this->once())
            ->method('getGamesInDivisions')
            ->willReturn([]);

        $this->dataDBPreparationMock->expects($this->once())
            ->method('getGamesDataForInsert')
            ->willReturn([]);

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertGames');

        $this->infoAggregatorMock->expects($this->once())
            ->method('getScoreInDivisions')
            ->willReturn([]);

        $this->infoAggregatorMock->expects($this->once())
            ->method('getPositionsInDivisions')
            ->willReturn([]);

        $this->dataDBPreparationMock->expects($this->once())
            ->method('getPositionsDataForInsert')
            ->willReturn([]);

        $this->dataDBProxyMock->expects($this->once())
            ->method('insertPositions');

        $infoBuilder->writeDataToDB();
    }
}
