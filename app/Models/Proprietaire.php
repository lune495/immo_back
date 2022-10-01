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

    public function biens()
    {
        return $this->hasMany(Bien::class);
    }
}
