<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assujetissement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function proprietaires()
    {
        return $this->hasMany(Proprietaire::class);
    }
}