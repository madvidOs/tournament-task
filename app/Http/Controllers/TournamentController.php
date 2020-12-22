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
     * @param  \App\Library\Services\Tournament\PlayoffManager $playoffManager
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(
        Request $request, 
        DivisionsManager $divisionsManager, 
        PlayoffManager $playoffManager
    ) {       
        //check request if ajax and json
        if (!$request->ajax() && !$request->expectsJson()) {
            abort(403);
        }

        $divisionsResults = $divisionsManager->getGamesResults();        
        $playoffResults = $playoffManager->getGamesResults();

        //union of results
        $result = array_merge($divisionsResults, $playoffResults);

        return response()->json($result);
    }   
    
}
