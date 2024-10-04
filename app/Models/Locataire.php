<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locataire extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bien_immo()
    {
        return $this->belongsTo(BienImmo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function locataire_taxes()
    {
        return $this->hasMany(LocataireTaxe::class);
    }

    public function compte_locataires()
    {
        return $this->hasMany(CompteLocataire::class);
    }

    public function detail_journals()
    {
        return $this->hasMany(DetailJournal::class);
    }

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

    public function libererUnite()
    {
        $this->update(['resilier' => true]);
        $this->unite->dispo = false;
        $this->unite->save();
        // $this->bien_immo()->dissociate();
        // $this->unite()->dissociate();
        $this->save();
    }
}