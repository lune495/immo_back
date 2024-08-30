<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{DepenseProprio,Outil};
use Illuminate\Support\Facades\DB;

class DepenseProprioController extends Controller
{
    //
    private $queryName = "depense_proprios";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new DepenseProprio();
                if (!empty($request->id))
                {
                    $item = DepenseProprio::find($request->id);
                }
                if (empty($request->libelle))
                {
                    $errors = "Renseignez la nature de la depense";
                }
                $item->libelle = $request->libelle;
                if (!isset($errors)) 
                {
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
