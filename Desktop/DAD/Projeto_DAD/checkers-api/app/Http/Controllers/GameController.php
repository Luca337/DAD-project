<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function myHistory(Request $request)
    {
        $userId = $request->user()->id;

        // Procura os jogos onde o utilizador foi o jogador branco OU o jogador preto
        $games = Game::where('player_white_id', $userId)
                     ->orWhere('player_black_id', $userId)
                     ->get();

        return response()->json($games);
    }
}