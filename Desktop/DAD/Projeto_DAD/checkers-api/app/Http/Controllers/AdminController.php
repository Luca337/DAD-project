<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Game;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listUsers()
    {
        return response()->json(User::all());
    }

    public function auditLedger()
    {
        $transactions = Transaction::with('wallet.user')->get();
        return response()->json($transactions);
    }

    // Devolve as estatísticas operacionais da plataforma[cite: 3]
    public function getMetrics()
    {
        $totalUsers = User::where('role', 'player')->count();
        $totalPlatformMoney = Wallet::sum('balance');
        $totalGames = Game::count();

        return response()->json([
            'total_players' => $totalUsers,
            'total_money_in_circulation' => (float) $totalPlatformMoney,
            'total_games_played' => $totalGames
        ]);
    }

    // Consulta os detalhes de um utilizador específico[cite: 3]
    public function showUser($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'Utilizador não encontrado'], 404);
        }
        
        return response()->json($user);
    }

    // Apaga/Bane um utilizador da plataforma[cite: 3]
    public function deleteUser($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'Utilizador não encontrado'], 404);
        }
        
        // Medida de segurança: não deixar um admin apagar outro admin (ou a si próprio)
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Não é possível apagar contas de administrador'], 403);
        }

        $user->delete();
        
        return response()->json(['message' => 'Conta apagada com sucesso']);
    }
}