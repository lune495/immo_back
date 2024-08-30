<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bien_immo()
    {
        return $this->belongsTo(BienImmo::class);
    }

    public  function nature_local()
    {
        return $this->belongsTo(NatureLocal::class);
    }

    public  function locataires()
    {
        return $this->hasMany(Locataire::class);
    }
}