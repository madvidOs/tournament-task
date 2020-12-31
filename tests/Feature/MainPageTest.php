<?php

namespace Tests\Feature;

use Tests\TestCase;

class MainPageTest extends TestCase
{
    /**
     * Check getting main page
     *
     * @return void
     */
    public function testMainPageAccess()
    {
        $response = $this->get('/');

        //Get page
        $response->assertStatus(200);
        //Check text
        $response->assertSeeText('Tournament');
    }

    /**
     * Check working ajax request
     *
     * @return void
     */
    public function testAjaxRequest()
    {        

        $response = $this->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ])->get('/create');

        //Get responce
        $response->assertSuccessful();        
        //Check structure        
        $response->assertJsonStructure([
            'divisions' => [ 
                '*' => [
                    'divisionId',
                    'divisionName',
                    'games', 
                    'positions', 
                    'score',
                    'teams'
                ],
            ],    
            'playoff' => [
                'bracket',
                'games',
                'teamsNames',
                'winners'
            ]            
        ]);
        
        
    }
}
