<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteCautionLocataire extends Model
{
    use HasFactory;

    public  function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }
}
