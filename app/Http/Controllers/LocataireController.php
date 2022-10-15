<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Locataire,Outil,Taxe,LocataireTaxe};
use Illuminate\Support\Facades\DB;

class LocataireController extends Controller
{
    //
    private $queryName = "locataires";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                $errors =null;
                $item = new Locataire();
                $array[] = null;
                $avec_taxe = false;
                if (!empty($request->id))
                {
                    $item = Locataire::find($request->id);
                }
                if (empty($request->nom))
                {
                    $errors = "Renseignez le nom du proprietaire";
                }
                if (empty($request->prenom))
                {
                    $errors = "Renseignez le prenom du proprietaire";
                }
                if (empty($request->statut))
                {
                    $errors = "Renseignez le statut de la location";
                }
                if($request->statut == 'habitation')
                {
                    $item->montant_loyer = $request->montant_loyer;
                    $item->montant_loyer_ttc = $request->montant_loyer;
                    $item->montant_loyer_ht = $request->montant_loyer;
                }
                elseif($request->statut == 'commerciale'){
                    if($request->type_taxe == 'ttc'){
                        $montant_loyer = $request->montant_loyer;
                        $tva = !(array_key_exists('tva', $request->all())) ? false : true;
                        $tom = !(array_key_exists('tom', $request->all())) ? false : true;
                        $tlv = !(array_key_exists('tlv', $request->all())) ? false : true;
                        $cc =  !(array_key_exists('cc', $request->all())) ? false : true;
                        $tva = $tva == true ? Taxe::where('nom','tva')->first() : false;
                        $tom = $tom == true ? Taxe::where('nom','tom')->first() : false;
                        $tlv = $tlv == true ? Taxe::where('nom','tlv')->first() : false;
                        $cc = $cc == true ?  $request->cc : false;
                        $loyerHt = Outil::loyerht($montant_loyer,$tva->value,$tom->value,$tlv->value,$cc);
                        $montant_loyer = $request->montant_loyer;
                        $item->montant_loyer_ht = $loyerHt;
                        $item->montant_loyer = $montant_loyer;
                        $item->montant_loyer_ttc = $montant_loyer;
                        if($tva != false)
                        {
                            array_push($array, $tva->id);
                            $avec_taxe = true;
                        }
                        if($tom != false)
                        {
                            array_push($array, $tom->id);
                        }
                        if($tlv != false)
                        {
                            array_push($array, $tlv->id);
                        }   
                    }elseif ($request->type_taxe == 'ht') {
                        $montant_loyer = $request->montant_loyer;
                        $tva = !(array_key_exists('tva', $request->all())) ? false : true;
                        $tom = !(array_key_exists('tom', $request->all())) ? false : true;
                        $tlv = !(array_key_exists('tlv', $request->all())) ? false : true;
                        $cc =  !(array_key_exists('cc', $request->all())) ? false : true;
                        $tva = $tva == true ? Taxe::where('nom','tva')->first() : false;
                        $tom = $tom == true ? Taxe::where('nom','tom')->first() : false;
                        $tlv = $tlv == true ? Taxe::where('nom','tlv')->first() : false;
                        $cc = $cc == true ?  $request->cc : false;
                        $loyerttc = Outil::loyerttc($montant_loyer,$tva->value,$tom->value,$tlv->value,$cc);
                        $montant_loyer_ttc = $loyerttc;
                        $item->montant_loyer_ht = $request->montant_loyer;
                        $item->montant_loyer = $montant_loyer;
                        if($tva != false)
                        {
                            array_push($array, $tva->id);
                            $avec_taxe = true;
                        }
                        if($tom != false)
                        {
                            array_push($array, $tom->id);
                        }
                        if($tlv != false)
                        {
                            array_push($array, $tlv->id);
                        }
                    }
                }          
                $item->nom = $request->nom;
                $item->code = "000001";
                $item->prenom = $request->prenom;
                $item->cni = $request->cni;
                $item->telephone = $request->telephone;
                $item->bien_immo_id = $request->bien_immo_id;
                $item->descriptif_loyer = $request->descriptif_loyer;
                dd($item);
                if (!isset($errors)) 
                {
                    $item->save();
                    $proprio_id = $item->bien_immo->proprietaire_id;
                    $id = $item->id;
                    $item->code = "L000{$id}/{$proprio_id}";
                    $item->save();
                    if($avec_taxe)
                    {
                        for ($i = 1; $i <= count($array) -1; $i++) {
                        $lt = new LocataireTaxe();
                        $lt->locataire_id = $id;
                        $lt->taxe_id = $array[$i];
                        $lt->save();
                    }
                    }
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
