<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeBienImmo extends Model
{
    use HasFactory;

    public function bien_immos()
    {
        return $this->hasMany(BienImmo::class);
    }
}
