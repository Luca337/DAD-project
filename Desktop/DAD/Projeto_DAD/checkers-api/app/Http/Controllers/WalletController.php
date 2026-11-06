<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function myWallet(Request $request)
    {
        $user = $request->user();
        
        // Procura a carteira do utilizador
        $wallet = $user->wallet()->first();

        // Se não existir nenhuma, o sistema cria uma automaticamente com saldo zero
        if (!$wallet) {
            $wallet = $user->wallet()->create(['balance' => 0]);
        }

        // Carrega o histórico de transações associado a esta carteira
        $wallet->load('transactions');

        return response()->json([
            'balance' => $wallet->balance,
            'transactions' => $wallet->transactions
        ]);
    }
}