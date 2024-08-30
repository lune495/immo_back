<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NatureLocal extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    public function unites()
    {
        return $this->hasMany(Unite::class);
    }
}
