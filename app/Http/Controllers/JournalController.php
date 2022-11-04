<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Compte,Locataire,Outil,Journal};
use Illuminate\Support\Facades\DB;
class JournalController extends Controller
{
    //
    private $queryName = "journals";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $str_json = json_encode($request->detail_journals);
                $detail_journals = json_decode($str_json, true);
                if (!empty($request->id))
                {
                    $item = Journal::find($request->id);
                }
                
                foreach ($detail_journals as $detail) 
                {
                    $item = new Journal();
                    if (isset($detail['locataire_id']))
                    {
                        $locataire = Locataire::where("id",$detail['locataire_id'])->get();
                    }
                    if(!$locataire->first())
                    {
                        $errors = "Ce locataire n'existe pas";
                    }
                    if (empty($detail['libelle']))
                    {
                        $errors = "Renseignez le libelle";
                    }
                    if (empty($detail['entree']) && empty($detail['sortie']))
                    {
                        $errors = "veuillez préciser le type d'opération";
                    }
                    $item->libelle = $detail['libelle'];
                    $item->entree =   $detail['entree'];
                    $item->sortie = $detail['sortie'];
                    $item->solde = $detail['solde'];
                    $item->locataire_id = $detail['locataire_id'];
                if (!isset($errors)) 
                {
                    $item->save();
                    if($request->entree !=0 && $request->sortie ==0){
                        $proprio_id = $item->locataire->bien_immo->proprietaire_id;
                        $compte = Compte::where('proprietaire_id', $proprio_id)->first();
                        $compte->montant_compte = $compte->montant_compte + $request->entree;
                        $compte->save();
                    }
                    if($request->sortie !=0 && $request->entree ==0){
                        $proprio_id = $item->locataire->bien_immo->proprietaire_id;
                        $compte = Compte::where('proprietaire_id', $proprio_id)->first();
                        $compte->montant_compte = $compte->montant_compte - $request->sortie;
                        $compte->save();
                        }
                }
                }
                if (isset($errors))
                {
                    throw new \Exception($errors);
                }
                DB::commit();
                return  Outil::redirectgraphql2($this->queryName,Outil::$queries[$this->queryName]);
          });
        } catch (exception $e) {            
             DB::rollback();
             return $e->getMessage();
        }
    }
}