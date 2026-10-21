<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Notification envoyée par le manager à un client
class Notice extends Model
{
    protected $table = 'notices';

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
