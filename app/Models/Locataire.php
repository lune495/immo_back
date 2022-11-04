<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locataire extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bien_immo()
    {
        return $this->belongsTo(BienImmo::class);
    }

    public function locataire_taxes()
    {
        return $this->hasMany(LocataireTaxe::class);
    }

     public function journals()
    {
        return $this->hasMany(Journal::class);
    }
    
    
}
