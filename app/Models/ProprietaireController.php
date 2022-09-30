<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Proprietaire,Agence,Outil};
use Illuminate\Support\Facades\DB;

class ProprietaireController extends Controller
{
    //
    private $queryName = "proprietaires";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new Proprietaire();
                $agence = Agence::find(1);
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
                $item->nom = $request->nom;
                $item->code = "GB000-0";
                $item->prenom = $request->prenom;
                $item->telephone = $request->telephone;
                $item->agence_id = $agence->id;
                if (!isset($errors)) 
                {
                    $item->save();
                    $id = $item->id;
                    $item->code = "GB000-0-{$id}";
                    $item->save();
                    $id = $item->id;
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
