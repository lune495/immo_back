<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienImmo extends Model
{
    use HasFactory; 
    protected $guarded = [];


    public function locataire()
    {
        return $this->hasOne(Locataire::class);
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
}
