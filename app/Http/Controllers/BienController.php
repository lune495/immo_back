<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Bien,Proprietaire,Outil};
use Illuminate\Support\Facades\DB;

class BienController extends Controller
{
    //
     private $queryName = "biens";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                $errors =null;
                $item = new Bien();
                if (!empty($request->id))
                {
                    $item = Bien::find($request->id);
                }
                if (empty($request->description))
                {
                    $errors = "Renseignez la description du Bien";
                }
                if (empty($request->adresse))
                {
                    $errors = "Renseignez l'adresse";
                }
                $item->code = "00000000";
                $item->description = $request->description;
                $item->adresse = $request->adresse;
                $item->proprietaire_id = $request->proprietaire_id;
                $item->type_bien_immo_id = $request->type_bien_immo_id;
                if (!isset($errors)) 
                {
                    $item->save();
                    $id = $item->id;
                    $item->code = "GB0000-{$id}";
                    $item->save();
                    $proprio = Proprietaire::with('biens')->find($item->proprietaire_id);
                    $nbr_bien = count($proprio->biens);
                    $proprio_id = $proprio->id;
                    $proprio->code = "B000-{$nbr_bien}-{$proprio_id}";
                    $proprio->save();
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
