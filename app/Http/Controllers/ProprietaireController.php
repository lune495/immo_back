<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Proprietaire,Agence,Outil};

class ProprietaireController extends Controller
{
    //
    private $queryName = "proprietaires";

     public function save(Request $request)
    {
        try 
        {
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
                $item->code = "000001";
                $item->prenom = $request->prenom;
                $item->telephone = $request->telephone;
                $item->agence_id = $agence->id;
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
