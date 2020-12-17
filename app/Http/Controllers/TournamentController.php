<?php

namespace App\Http\Controllers;

use App\Library\Services\Tournament\DivisionsManager;
use App\Library\Services\Tournament\PlayoffManager;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Display a listing of divisions
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        DivisionsManager $divisionsManager
    ) {        
        $divisionsWithTeams = $divisionsManager->getDivisionsWithParticipants();             
        return view('tournament/home', compact('divisionsWithTeams'));
    }

    /**
     * Return results of games (division and playoff levels)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library\Services\Tournament\DivisionsManager  $divisionsManager
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(
        Request $request, 
        DivisionsManager $divisionsManager, 
        PlayoffManager $playoffManager
    ) {       
        //check request if ajax and json
        /*if (!$request->ajax() && !$request->expectsJson()) {
            abort(403);
        }*/

        $divisionGamesResult = $divisionsManager->getGamesResults();        
        $plaoffGameResults = $playoffManager->getGamesResults();

        $result = array_merge($divisionGamesResult, $plaoffGameResults);
        //dd($result);

        return response()->json($result);
    }   
    
}
