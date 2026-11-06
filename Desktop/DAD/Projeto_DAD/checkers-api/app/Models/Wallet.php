<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['balance'];

    // Uma carteira tem muitas transações
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}