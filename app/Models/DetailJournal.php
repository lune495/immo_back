<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJournal extends Model
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
    public  function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public  function depense_proprio()
    {
        return $this->belongsTo(DepenseProprio::class);
    }
}