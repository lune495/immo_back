<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{BienImmo,Outil,Proprietaire};
use Illuminate\Support\Facades\DB;


class BienImmoController extends Controller
{
    private $queryName = "bien_immos";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new BienImmo();
                if (!empty($request->id))
                {
                    $item = BienImmo::find($request->id);
                }
                if (empty($request->description))
                {
                    $errors = "Renseignez la description du Bien immobiler";
                }
                $item->code = "000001";
                $item->description = $request->description;
                $item->loyer = $request->loyer;
                $item->adresse = $request->adresse;
                $item->proprietaire_id = $request->proprietaire_id;
                $item->type_bien_immo_id = $request->type_bien_immo_id;
                if (!isset($errors)) 
                {
                    $item->save();
                    $id = $item->id;
                    $item->code = "GB0000-{$id}";
                    $item->save();
                    $proprio = Proprietaire::with('bien_immos')->find($item->proprietaire_id);
                    $nbr_bien = count($proprio->bien_immos);
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
