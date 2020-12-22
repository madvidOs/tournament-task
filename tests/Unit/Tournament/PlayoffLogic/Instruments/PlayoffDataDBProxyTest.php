<?php

namespace Tests\Unit\Tournament\PlayoffLogic\Instruments;

use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBProxy;
use App\Repositories\Tournament\PlayoffBracketRepository;
use App\Repositories\Tournament\PlayoffGameRepository;
use App\Repositories\Tournament\PlayoffParticipantRepository;
use App\Repositories\Tournament\PlayoffWinnerRepository;
use PHPUnit\Framework\TestCase;

class PlayoffDataDBProxyTest extends TestCase
{

    private $playoffBracketRepositoryStub;
    private $playoffParticipantRepositoryStub;
    private $playoffGameRepositoryStub;
    private $playoffWinnerRepositoryStub;

    protected function setUp(): void
    {        
        $this->playoffBracketRepositoryStub = $this->getMockBuilder(PlayoffBracketRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'truncate',
                'insert',               
            ])->getMock();

        $this->playoffParticipantRepositoryStub = $this->getMockBuilder(PlayoffParticipantRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'truncate',
                'insert',               
            ])->getMock();  
            
        $this->playoffGameRepositoryStub = $this->getMockBuilder(PlayoffGameRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'truncate',
                'insert',
            ])->getMock();

        $this->playoffWinnerRepositoryStub = $this->getMockBuilder(PlayoffWinnerRepository::class)
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
        $this->playoffBracketRepositoryStub->expects($this->once())
            ->method('truncate');
            
        $this->playoffBracketRepositoryStub->expects($this->once())
            ->method('insert');    
        
        $playoffDataDBProxy = new PlayoffDataDBProxy(
            $this->playoffBracketRepositoryStub,
            $this->playoffParticipantRepositoryStub,
            $this->playoffGameRepositoryStub,
            $this->playoffWinnerRepositoryStub,

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
        $this->playoffParticipantRepositoryStub->expects($this->once())
            ->method('truncate');
            
        $this->playoffParticipantRepositoryStub->expects($this->once())
            ->method('insert');    
        
        $playoffDataDBProxy = new PlayoffDataDBProxy(
            $this->playoffBracketRepositoryStub,
            $this->playoffParticipantRepositoryStub,
            $this->playoffGameRepositoryStub,
            $this->playoffWinnerRepositoryStub,

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
        $this->playoffGameRepositoryStub->expects($this->once())
            ->method('truncate');
            
        $this->playoffGameRepositoryStub->expects($this->once())
            ->method('insert');    
        
        $playoffDataDBProxy = new PlayoffDataDBProxy(
            $this->playoffBracketRepositoryStub,
            $this->playoffParticipantRepositoryStub,
            $this->playoffGameRepositoryStub,
            $this->playoffWinnerRepositoryStub,

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
        $this->playoffWinnerRepositoryStub->expects($this->once())
            ->method('truncate');
            
        $this->playoffWinnerRepositoryStub->expects($this->once())
            ->method('insert');    
        
        $playoffDataDBProxy = new PlayoffDataDBProxy(
            $this->playoffBracketRepositoryStub,
            $this->playoffParticipantRepositoryStub,
            $this->playoffGameRepositoryStub,
            $this->playoffWinnerRepositoryStub,

        );
        $playoffDataDBProxy->insertWinners([]);
        
    }
    
}
