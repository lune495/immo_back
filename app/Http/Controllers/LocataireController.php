<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Locataire,Outil};

class LocataireController extends Controller
{
    //
    private $queryName = "locataires";

     public function save(Request $request)
    {
        try 
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
                $item->proprietaire_id = $request->proprietaire_id;
                if (!isset($errors)) 
                {
                    $item->save();
                    $id = $item->id;
                    return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
                }
                if (isset($errors))
                {
                    throw new \Exception('{"data": null, "errors": "'. $errors .'" }');
                }
        } catch (exception $e) {
                return $e->getMessage();
        }
    }
}
