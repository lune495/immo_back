<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Compte,Locataire,DetailJournal,Outil,Journal};
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
                $item = new Journal();
                if (!empty($request->id))
                {
                    $item = Journal::find($request->id);
                }
                
                $item->solde = $request->solde;
                $item->save();
                foreach ($detail_journals as $detail) 
                {
                    $detail_journals= new DetailJournal();
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
                    $detail_journals->libelle = $detail['libelle'];
                    $detail_journals->entree =   $detail['entree'];
                    $detail_journals->sortie = $detail['sortie'];
                    $detail_journals->locataire_id = $detail['locataire_id'];
                    $detail_journals->journal_id = $item->id;
                if (!isset($errors)) 
                {
                    $detail_journals->save();
                    $id = $item->id;
                    if($request->entree !=0 && $request->sortie ==0){
                        $proprio_id = $detail->locataire->bien_immo->proprietaire_id;
                        $compte = Compte::where('proprietaire_id', $proprio_id)->first();
                        $compte->montant_compte = $compte->montant_compte + $request->entree;
                        $compte->save();
                    }
                    if($request->sortie !=0 && $request->entree ==0){
                        $proprio_id = $detail->locataire->bien_immo->proprietaire_id;
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
                return  Outil::redirectgraphql($this->queryName,"id:{$id}",Outil::$queries[$this->queryName]);
          });
        } catch (exception $e) {            
             DB::rollback();
             return $e->getMessage();
        }
    }
}