<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    public  function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }

    public  function type_bien_immo()
    {
        return $this->belongsTo(TypeBienImmo::class);
    }

    public function bien_immos()
    {
        return $this->hasMany(BienImmo::class);
    }
}
