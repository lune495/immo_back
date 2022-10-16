<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TypeBienImmo,Outil};
use Illuminate\Support\Facades\DB;

class TypeBienImmoController extends Controller
{
      private $queryName = "type_bien_immos";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new TypeBienImmo();
                if (!empty($request->id))
                {
                    $item = TypeBienImmo::find($request->id);
                }
                if (empty($request->nom))
                {
                    $errors = "Renseignez le nom du type de bien immobilier ";
                }
                    $item->nom = $request->nom;
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
