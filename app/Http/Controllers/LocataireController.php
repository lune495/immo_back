<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Locataire,Outil};
use Illuminate\Support\Facades\DB;

class LocataireController extends Controller
{
    //
    private $queryName = "locataires";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                $errors =null;
                $item = new Locataire();
                if (!empty($request->id))
                {
                    $item = Locataire::find($request->id);
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
                $item->code = "000001";
                $item->prenom = $request->prenom;
                $item->cni = $request->cni;
                $item->telephone = $request->telephone;
                $item->bien_immo_id = $request->bien_immo_id;
                if (!isset($errors)) 
                {
                    $item->save();
                    $proprio_id = $item->bien_immo->proprietaire_id;
                    $id = $item->id;
                    $item->code = "L000{$id}-{$proprio_id}-{$id}";
                    $item->save();
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
