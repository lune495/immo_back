<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proprietaire extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public  function user()
    {
        return $this->belongsTo(User::class);
    }
    public  function assujetissement()
    {
        return $this->belongsTo(Assujetissement::class);
    }

    public function bien_immos()
    {
        return $this->hasMany(BienImmo::class);
    }

    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }

    public function locataires()
    {
        return $this->hasManyThrough(
            Locataire::class,
            BienImmo::class,
            'proprietaire_id', // Foreign key on BienImmo table
            'bien_immo_id', // Foreign key on Locataire table
            'id', // Local key on Proprietaire table
            'id' // Local key on BienImmo table
        );
    }
}
