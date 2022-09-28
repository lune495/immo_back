<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User,ProprioBienImmo,Outil,Proprietaire};
use Illuminate\Support\Facades\DB;
use \PDF;


class AffectationBienController extends Controller
{
    //
    private $queryName = "proprietaires";
    public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors = null;
                $item = new ProprioBienImmo();
                // $user_id = auth('sanctum')->user()->id;
                $user_id = 1;
                $str_json = json_encode($request->details);
                $details = json_decode($str_json, true);
                if (!isset($errors)) 
                {
                    foreach ($details as $detail) 
                    {
                        $getProduit = Proprietaire::find($detail['proprietaire_id']);
                        if($getProduit == null )
                        {
                            $errors = "Proprietaire  inexistant";
                        }
                        else
                        {
                            $itemDetail = new ProprioBienImmo();
                            $itemDetail->proprietaire_id = $detail['proprietaire_id'];
                            $itemDetail->bien_immo_id = $detail['bien_immo_id'];
                            $itemDetail->user_id = $user_id;
                            $itemDetail->save();
                        }
                    }
                }
                $itemId = $detail['proprietaire_id']; 
                if (isset($errors))
                {
                    throw new \Exception($errors);
                }
                 DB::commit();
                return  Outil::redirectgraphql($this->queryName, "id:{$itemId}", Outil::$queries[$this->queryName]);
            });
        } catch (exception $e) {            
             DB::rollback();
             return $e->getMessage();
        }
    }

}
