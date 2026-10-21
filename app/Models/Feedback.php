<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Message (feedback) envoyé par un client à la banque
class Feedback extends Model
{
    protected $table = 'feedbacks';

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
