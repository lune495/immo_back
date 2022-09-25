<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{BienImmo,Outil};


class BienImmoController extends Controller
{
    private $queryName = "bienimmos";

     public function save(Request $request)
    {
        try 
        {
                $errors =null;
                $item = new BienImmo();
                if (!empty($request->id))
                {
                    $item = BienImmo::find($request->id);
                }
                if (empty($request->desc))
                {
                    $errors = "Renseignez la description du Bien";
                }
                $item->adresse = $request->adresse;
                $item->code = "000001";
                $item->description = $request->desc;
                $item->montant = $request->loyer;
                $item->proprietaire_id = $request->proprietaire_id;
                $item->type_bien_immo_id = $request->type_bien_immo_id;
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
