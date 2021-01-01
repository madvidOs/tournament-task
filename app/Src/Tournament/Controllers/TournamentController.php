<?php

namespace App\Src\Tournament\Controllers;

use App\Http\Controllers\Controller;
use App\Src\Tournament\Services\DivisionsManager;
use App\Src\Tournament\Services\PlayoffManager;
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
     * @param  \App\Src\Tournament\Services\DivisionsManager  $divisionsManager
     * @param  \App\Src\Tournament\Services\PlayoffManager $playoffManager
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
