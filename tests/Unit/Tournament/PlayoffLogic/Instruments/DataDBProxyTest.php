<?php

namespace Tests\Unit\Tournament\PlayoffLogic\Instruments;

use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Repositories\PlayoffBracketRepository;
use App\Src\Tournament\Repositories\PlayoffGameRepository;
use App\Src\Tournament\Repositories\PlayoffParticipantRepository;
use App\Src\Tournament\Repositories\PlayoffWinnerRepository;
use PHPUnit\Framework\TestCase;

class DataDBProxyTest extends TestCase
{

    private $playoffBracketRepositoryMock;
    private $playoffParticipantRepositoryMock;
    private $playoffGameRepositoryMock;
    private $playoffWinnerRepositoryMock;

    protected function setUp(): void
    {        
        $this->playoffBracketRepositoryMock = $this->getMockBuilder(PlayoffBracketRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'truncate',
                'insert',               
            ])->getMock();

        $this->playoffParticipantRepositoryMock = $this->getMockBuilder(PlayoffParticipantRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'truncate',
                'insert',               
            ])->getMock();  
            
        $this->playoffGameRepositoryMock = $this->getMockBuilder(PlayoffGameRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'truncate',
                'insert',
            ])->getMock();

        $this->playoffWinnerRepositoryMock = $this->getMockBuilder(PlayoffWinnerRepository::class)
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
     * Test insertBracket method     
     *
     * @return void
     */
    public function testInsertBracket()
    {
        $this->playoffBracketRepositoryMock->expects($this->once())
            ->method('truncate');
            
        $this->playoffBracketRepositoryMock->expects($this->once())
            ->method('insert');    
        
        $playoffDataDBProxy = new DataDBProxy(
            $this->playoffBracketRepositoryMock,
            $this->playoffParticipantRepositoryMock,
            $this->playoffGameRepositoryMock,
            $this->playoffWinnerRepositoryMock,

        );
        $playoffDataDBProxy->insertBracket([]);
        
    }

    /**
     * Test insertParticipants method     
     *
     * @return void
     */
    public function testInsertParticipants()
    {
        $this->playoffParticipantRepositoryMock->expects($this->once())
            ->method('truncate');
            
        $this->playoffParticipantRepositoryMock->expects($this->once())
            ->method('insert');    
        
        $playoffDataDBProxy = new DataDBProxy(
            $this->playoffBracketRepositoryMock,
            $this->playoffParticipantRepositoryMock,
            $this->playoffGameRepositoryMock,
            $this->playoffWinnerRepositoryMock,

        );
        $playoffDataDBProxy->insertParticipants([]);
        
    }

        /**
     * Test insertGames method     
     *
     * @return void
     */
    public function testInsertGames()
    {
        $this->playoffGameRepositoryMock->expects($this->once())
            ->method('truncate');
            
        $this->playoffGameRepositoryMock->expects($this->once())
            ->method('insert');    
        
        $playoffDataDBProxy = new DataDBProxy(
            $this->playoffBracketRepositoryMock,
            $this->playoffParticipantRepositoryMock,
            $this->playoffGameRepositoryMock,
            $this->playoffWinnerRepositoryMock,

        );
        $playoffDataDBProxy->insertGames([]);
        
    }

    /**
     * Test insertWinners method     
     *
     * @return void
     */
    public function testInsertWinners()
    {
        $this->playoffWinnerRepositoryMock->expects($this->once())
            ->method('truncate');
            
        $this->playoffWinnerRepositoryMock->expects($this->once())
            ->method('insert');    
        
        $playoffDataDBProxy = new DataDBProxy(
            $this->playoffBracketRepositoryMock,
            $this->playoffParticipantRepositoryMock,
            $this->playoffGameRepositoryMock,
            $this->playoffWinnerRepositoryMock,

        );
        $playoffDataDBProxy->insertWinners([]);
        
    }
    
}
