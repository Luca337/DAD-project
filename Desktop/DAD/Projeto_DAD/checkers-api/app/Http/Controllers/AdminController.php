<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Lista todos os utilizadores para a gestão de contas[cite: 3]
    public function listUsers()
    {
        return response()->json(User::all());
    }

    // Retorna o livro de auditoria com todas as transações da plataforma[cite: 3]
    public function auditLedger()
    {
        // O "with('wallet.user')" carrega a quem pertence cada transação
        $transactions = Transaction::with('wallet.user')->get();
        return response()->json($transactions);
    }
}