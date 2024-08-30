<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Proprietaire,Compte,Agence,Outil};
use Illuminate\Support\Facades\DB;

class ProprietaireController extends Controller
{

    private $queryName = "proprietaires";

     public function save(Request $request)
     {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new Proprietaire();
                if (!empty($request->id))
                {
                    $item = Proprietaire::find($request->id);
                }
                if (empty($request->nom))
                {
                    $errors = "Renseignez le nom du proprietaire";
                }
                if (empty($request->prenom))
                {
                    $errors = "Renseignez le prenom du proprietaire";
                }
                if (empty($request->telephone))
                {
                    $errors = "Renseignez le numero de téléphone du proprietaire";
                }
                if (empty($request->agence_id))
                {
                    $errors = "Renseignez l'agence";
                }
                $item->nom = $request->nom;
                if (empty($request->id))
                {
                    $item->code = "B000-0";
                }
                if (!isset($errors))
                {
                    $item->prenom = $request->prenom;
                    $item->telephone = $request->telephone;
                    $item->agence_id = $request->agence_id;
                    $item->save();
                    $id = $item->id;
                    if (empty($request->id))
                    {
                        $item->code = "B000{$id}/0";
                    }
                    $item->save();
                    $id = $item->id;
                    $comptes = Compte::where("proprietaire_id",$id)->get();
                    if(!$comptes->first())
                    {
                        $compte = new Compte();
                        $compte->proprietaire_id = $id;
                        $compte->libelle = "New compte de `{$item->prenom}` `{$item->nom}`";
                        $compte->montant_compte = 0;
                        $compte->save();
                    }
                }
                if (isset($errors))
                {
                    throw new \Exception($errors);
                }
                DB::commit();
                return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
          });
        } catch (exception $e) {            
             DB::rollback();
             return $e->getMessage();
        }
    }
}