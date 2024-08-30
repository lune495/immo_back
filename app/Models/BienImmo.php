<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienImmo extends Model
{
    use HasFactory; 
    protected $guarded = [];

    public function locataires()
    {
        return $this->hasMany(Locataire::class);
    }
    public function unites()
    {
        return $this->hasMany(Unite::class);
    }
    public  function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }

    public  function type_bien_immo()
    {
        return $this->belongsTo(TypeBienImmo::class);
    }
}
