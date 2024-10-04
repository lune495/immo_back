<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteAgence extends Model
{
    use HasFactory;

    public  function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }
    public  function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }
}
