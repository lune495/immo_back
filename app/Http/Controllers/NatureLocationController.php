<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{NatureLocal,Outil};
use Illuminate\Support\Facades\DB;

class NatureLocationController extends Controller
{
    private $queryName = "nature_locations";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new NatureLocal();
                if (!empty($request->id))
                {
                    $item = NatureLocal::find($request->id);
                }
                if (empty($request->nom))
                {
                    $errors = "Renseignez la nature";
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
