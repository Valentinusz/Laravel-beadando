<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        return view('games', [
            'finished' => Game::where('finished', '=', true)
                ->orderBy('start')
                ->paginate(10),
            'ongoing' => Game::where('finished', '=', false)
                ->orderBy('start')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game) {
        return view('game', [
            'game' => $game
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game) {
        //
    }
}
