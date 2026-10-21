<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Compte bancaire d'un client
class Account extends Model
{
    protected $table = 'accounts';

    // le mot de passe n'est jamais renvoyé quand on convertit le modèle
    protected $hidden = ['password'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }

    // chemin de la photo du client (photo par défaut si aucune)
    public function photo()
    {
        return $this->image
            ? asset('frontend/images/clients/'.$this->image)
            : asset('frontend/images/hillary.jpg');
    }
}
