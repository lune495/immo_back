<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;

    public function proprietaires()
    {
        return $this->hasMany(Proprietaire::class);
    }
    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }
}
