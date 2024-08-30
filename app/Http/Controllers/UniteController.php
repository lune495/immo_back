<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Proprietaire,Unite,Compte,Agence,Outil};
use Illuminate\Support\Facades\DB;

class UniteController extends Controller
{
    //
    private $queryName = "bien_immos";
    public function save(Request $request)
    {
        try 
        {
            DB::beginTransaction();
                $errors =null;
                $id = $request->bien_immo_id;
                $str_json = json_encode($request->details);
                $details = json_decode($str_json, true); 
                if (!isset($errors)) 
                {
                    foreach ($details as $detail) 
                    {
                        $item = new Unite();
                        $item->bien_immo_id = $request->bien_immo_id;
                        $item->numero = $detail['numero'];
                        $item->nature_local_id = $detail['nature_local_id'];
                        $item->etage  = isset($detail['etage']) ? $detail['etage'] : 0;
                        $item->montant_loyer = isset($detail['montant_loyer']) ? $detail['montant_loyer'] : null;
                        $item->superficie_en_m2 = isset($detail['superficie_en_m2']) ? $detail['superficie_en_m2'] : null;
                        $item->annee_achevement = isset($detail['annee_achevement']) ? $detail['annee_achevement'] : "";
                        $item->nombre_piece_principale = $detail['nombre_piece_principale'];
                        $item->nombre_salle_de_bain = isset($detail['nombre_salle_de_bain']) ? $detail['nombre_salle_de_bain'] : 0;
                        $item->balcon = $detail['balcon'];
                        $item->type_localisation = $detail['type_localisation'];
                        $item->save();
                    }
                    DB::commit();
                    return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
                }
                if (isset($errors))
                {
                    throw new \Exception($errors);
                }

        } catch (exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
