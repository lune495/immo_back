<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;
     public function detail_journals()
    {
        return $this->hasMany(DetailJournal::class);
    }
    public  function user()
    {
        return $this->belongsTo(User::class);
    }
}
