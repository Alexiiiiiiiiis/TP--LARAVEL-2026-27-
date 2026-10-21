<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Opération sur un compte : deposit, withdraw, transfer (envoyé), received (reçu)
class Transaction extends Model
{
    protected $table = 'transactions';

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
