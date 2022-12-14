<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Model
{
    use HasFactory;
    protected $guarded = [];

    public  function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function bien_immos()
    {
        return $this->hasMany(BienImmo::class);
    }

    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }
}
