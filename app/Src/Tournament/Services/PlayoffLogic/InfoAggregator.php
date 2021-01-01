<?php
namespace App\Src\Tournament\Services\PlayoffLogic;

class InfoAggregator {

    private $participants;    
    private $bracket;
    private $games;
    private $winners;
    private $teamsNames;
    

    /**
     * Set participants
     * 
     * @return void    
     */
    public function setParticipants(array $srcParticipants) 
    {        
        $this->participants = $srcParticipants;    
    }

    /**
     * Set bracket
     *     
     * @return void
     */
    public function setBracket(array $bracket) 
    {
        $this->bracket = $bracket;
    }

    /**
     * Set games
     * 
     * @return void    
     */
    public function setGames(array $games) 
    {        
        $this->games   = $games;
    }

    /**
     * Set winners
     *
     * @return void
     */
    public function setWinners(array $winners) 
    {
        $this->winners = $winners;        
    }

    /**
     * Set teams names
     *   
     * @return void  
     */
    public function setTeamsNames(array $teamsNames) 
    {        
        $this->teamsNames = $teamsNames;
    }

    /**
     * Get participants
     *   
     * @return void  
     */
    public function getParticipants() 
    {        
        return $this->participants;    
    }

    /**
     * Get bracket
     *     
     * @return void
     */
    public function getBracket() 
    {        
        return $this->bracket;    
    }

    /**
     * Get games
     *  
     * @return void   
     */
    public function getGames() 
    {        
        return $this->games;    
    }

    /**
     * Get winners games
     *     
     * @return void
     */
    public function getWinnersGames() 
    {        
        return $this->games[3];    
    }


    /**
     * Get winners
     *   
     * @return void  
     */
    public function getWinners() 
    {        
        return $this->winners;    
    }

    /**
     * Get teams names
     * 
     * @return void    
     */
    public function getTeamsNames() 
    {        
        return $this->teamsNames;    
    }
    

    /**
     * Get response
     *
     * @return array
     */
    public function toArray(array $items) 
    {
        
        $result = [];

        if (in_array('bracket', $items)) {
            $result['bracket'] = $this->bracket;
        }

        if (in_array('games', $items)) {
            $result['games'] = $this->games;
        }

        if (in_array('winners', $items)) {
            $result['winners'] = $this->winners;
        }        

        if (in_array('teamsNames', $items)) {
            $result['teamsNames'] = $this->teamsNames;
        }        

        return ['playoff' => $result];
    }
}