<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membre du personnel : manager ou caissier
class Staff extends Model
{
    protected $table = 'staff';

    protected $hidden = ['password'];
}
