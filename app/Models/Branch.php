<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Agence bancaire
class Branch extends Model
{
    protected $table = 'branches';

    // une agence possède plusieurs comptes
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
