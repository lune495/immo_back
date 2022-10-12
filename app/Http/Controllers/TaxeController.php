<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{Taxe,Outil};
use Illuminate\Support\Facades\DB;

class TaxeController extends Controller
{
    //
    private $queryName = "taxes";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new Taxe();
                if (!empty($request->id))
                {
                    $item = Taxe::find($request->id);
                }
                if (empty($request->nom))
                {
                    $errors = "Renseignez la taxe";
                }
                if (empty($request->value))
                {
                    $errors = "Renseignez la valeur";
                }
                $item->nom = $request->nom;
                $item->value = $request->value;
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
