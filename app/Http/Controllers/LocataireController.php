<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Locataire,Outil,Unite,Taxe,LocataireTaxe,BienImmo,CompteLocataire,Agence,CompteCautionLocataire};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use \PDF;
use App\Events\MyEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuittanceLoyerMail;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;


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
                $user = Auth::user();
                $array = [];
                $avec_taxe = false;
                if (!empty($request->id))
                {
                    $item = Locataire::find($request->id);
                }
                if (empty($request->nom))
                {
                    $errors = "Renseignez le nom du locataire";
                }
                if (empty($request->prenom))
                {
                    $errors = "Renseignez le prénom du locataire";
                }
                if (empty($request->statut))
                {
                    $errors = "Renseignez le statut de la location";
                }
                // if (empty($request->cni))
                // {
                //     $errors = "Renseignez le CNI";
                // }
                if (empty($request->telephone))
                {
                    $errors = "Renseignez le numero de telephone";
                }
                // if (empty($request->adresse_profession))
                // {
                //     $errors = "Renseignez l'adresse profession";
                // }
                // if (empty($request->profession))
                // {
                //     $errors = "Renseignez la profession";
                // }
                // if (empty($request->descriptif_loyer))
                // {
                //     $errors = "Renseignez la description du loyer ";
                // }
                if (empty($request->bien_immo_id))
                {
                    $errors = "Renseignez le Bien immobilier";
                }
                if (empty($request->unite_id))
                {
                    $errors = "Selectionnez un parmi les locaux disponibles";
                }
                elseif($request->statut == 'commerciale' || $request->statut == 'habitation'){
                $montant_loyer_ht = $request->montant_loyer;
                $tva = !(array_key_exists('tva', $request->all())) ? false : Taxe::where('nom','TVA')->first();
                $tom = !(array_key_exists('tom', $request->all())) ? false : Taxe::where('nom','TOM')->first();
                $tlv = !(array_key_exists('tlv', $request->all())) ? false : Taxe::where('nom','TLV')->first();
                $cc =  !(array_key_exists('cc', $request->all())) ? false : true;
                $cc = $cc == true ?  $request->cc : false;
                $tva = $request->statut == 'habitation' ? false : $tva;
                $montant_loyer_ttc = Outil::loyerttc($montant_loyer_ht,$tva,$tom,$tlv,$cc);
                $item->montant_loyer_ht = $request->montant_loyer;
                $item->montant_loyer_ttc = $montant_loyer_ttc;
                if ($tva != false) {
                    array_push($array, ['id' => $tva->id, 'value' => $tva->value]);
                    $avec_taxe = true;
                }
                if ($tom != false) {
                    array_push($array, ['id' => $tom->id, 'value' => $tom->value]);
                    $avec_taxe = true;
                }
                if ($tlv != false) {
                    array_push($array, ['id' => $tlv->id, 'value' => $tlv->value]);
                    $avec_taxe = true;
                }
                if ($cc != false) {
                    $cc2 = Taxe::where('nom','CC')->first();
                    if($cc2){
                        array_push($array, ['id' => $cc2->id, 'value' => $cc]);
                        $avec_taxe = true;
                    }
                }
                }else{
                    $errors = "Renseignez le type de location";
                }

                 $unite = Unite::find($request->unite_id);
                 $locataires = Locataire::where("unite_id",$request->unite_id)->get();
                 foreach ($locataires as $locataire) {
                    if ($locataire->dispo == true) {
                        $errors = "Local déjà occupé";
                        break; // Stoppe la boucle dès qu'un locataire résilié est trouvé
                    }
                }
                 if($unite){
                    if($unite->dispo){
                        $errors = "Local choisi non disponible";
                     }
                 }
                
                if (!isset($errors))
                {
                        $item->nom = $request->nom;
                        $item->code = "000001";
                        $item->prenom = $request->prenom;
                        $item->user_id = $user->id;
                        // $item->user_id = 1;
                        $item->CNI = $request->cni;
                        $item->adresse_profession = $request->adresse_profession;
                        $item->situation_matrimoniale = $request->situation_matrimoniale;
                        $item->profession = $request->profession;
                        $item->telephone = $request->telephone;
                        $item->multipli = $request->multipli;
                        $item->unite_id = $request->unite_id;
                        $item->bien_immo_id = $request->bien_immo_id;
                        $item->cc = $cc == true ?  $request->cc : 0;
                        $item->descriptif_loyer = $request->descriptif_loyer;
                        $item->save();
                        $unite->dispo = true;
                        $unite->save();
                        $proprio_id = $item->bien_immo->proprietaire_id;
                        $id = $item->id;
                        $item->code = "L000{$id}/{$proprio_id}";
                        $saved = $item->save();
                    if ($saved) {
                        $caution = $request->caution;
                        // Vérifier si caution est un nombre
                        if (is_numeric($caution)) {
                        // Convertir caution en nombre flottant
                        $caution_num = floatval($caution);
                        }else{
                            $errors = "Format Caution Invalide";
                        }
                        // Assigner la valeur négative à credit
                        $compte_locataire = new CompteLocataire();
                        $compte_locataire->locataire_id = $id;
                        $compte_locataire->libelle = 'NP';
                        $compte_locataire->dernier_date_paiement = Carbon::now();
                        $compte_locataire->debit = $montant_loyer_ttc;
                        $compte_locataire->credit = 0;
                        $compte_locataire->statut_paye = false;
                        $compte_locataire->save();
                        $item->solde = $compte_locataire->debit;
                        $item->save();
                        $compte_caution_locataire = new CompteCautionLocataire();
                        $compte_caution_locataire->locataire_id = $id;    
                        $compte_caution_locataire->montant_compte = $caution;
                        $compte_caution_locataire->save();
                    }
                    if ($avec_taxe) 
                    {
                        foreach ($array as $taxe) {
                            $lt = new LocataireTaxe();
                            $lt->locataire_id = $id;
                            $lt->taxe_id = $taxe['id'];
                            $lt->value = $taxe['value'];
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

    public function generatesituationparlocataire($locataireId, $startDateOrToken = null, $endDateOrNull = null, $tokenOrNull = null)
    {
        $user = null;
        
        // Vérification de l'argument du token en fonction des valeurs fournies
        if ($endDateOrNull === null && $tokenOrNull === null) {
            // Si aucun endDate ou token n'est fourni, vérifier si startDateOrToken est un token
            $token = PersonalAccessToken::findToken($startDateOrToken);
            if (!$token || !$token->tokenable) {
                return response()->json(['message' => 'Token invalide'], 401);
            }
            $user = $token->tokenable;
        } else {
            // Si un token est fourni dans endDateOrNull
            $token = PersonalAccessToken::findToken($tokenOrNull);
            if (!$token || !$token->tokenable) {
                return response()->json(['message' => 'Token invalide'], 401);
            }
            $user = $token->tokenable;
        }
    
        // Vérifier si l'ID du locataire est fourni
        if ($locataireId !== null) {
            $data = [];
            $locataire = Locataire::with('bien_immo')->find($locataireId);
            
            // Si le locataire n'est pas trouvé, retourner une erreur
            if (!$locataire) {
                return response()->json(['message' => 'Locataire non trouvé'], 404);
            }
    
            // Définir les dates de début et de fin
            if ($startDateOrToken === null || $endDateOrNull === null) {
                // Si aucune date n'est fournie, utiliser le mois courant
                $startDate = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
                $endDate = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
            } else {
                // Valider et formater les dates fournies
                try {
                    $startDate = Carbon::createFromFormat('Y-m-d', $startDateOrToken)->startOfDay()->format('Y-m-d H:i:s');
                    $endDate = Carbon::createFromFormat('Y-m-d', $endDateOrNull)->endOfDay()->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    return response()->json(['message' => 'Dates invalides'], 400);
                }
            }
    
            // Requête pour obtenir les transactions du locataire
            $transactions = CompteLocataire::where('locataire_id', $locataireId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
    
            // Initialisation des variables
            $totalCredits = 0;
            $totalDebits = 0;
            $balance = 0;
            $records = [];
    
            // Processer les transactions
            foreach ($transactions as $transaction) {
                $date = \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y');
                $balance += ($transaction->debit - $transaction->credit);
                $totalCredits += $transaction->credit;
                $totalDebits += $transaction->debit;
    
                // Ajouter les données au tableau des enregistrements
                $records[] = [
                    'date' => $date,
                    'libelle' => $transaction->debit > 0 
                                 ? "Paiement dû" 
                                 : ($transaction->credit > 0 
                                    ? "Paiement du '{$date}'" 
                                    : "Aucune Opération"),
                    'debit' => $transaction->debit,
                    'credit' => $transaction->credit,
                    'balance' => $balance,
                ];
            }
    
            // Préparer les données pour la vue PDF avec le même format que generatesituationparlocataire2
            $data['records'] = $records;
            $data['totalCredits'] = $totalCredits;
            $data['totalDebits'] = $totalDebits;
            $data['balance'] = $balance;
            $data['start'] = $startDate ? date("d/m/Y", strtotime($startDate)) : 'N/A';
            $data['end'] = $endDate ? date("d/m/Y", strtotime($endDate)) : 'N/A';
            $data['locataire'] = $locataire;
            $data['user'] = $user;
            // Générer le PDF
            $pdf = PDF::loadView("pdf.situationlocataire", $data);
            return $pdf->stream();
        } else {
            return response()->json(['message' => 'Locataire non trouvé'], 404);
        }
    }
    
    





    
public function uploadContract(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:jpg,png,pdf|max:2048',
        'locataire_id' => 'required|exists:locataires,id',
    ]);

    $file = $request->file('file');
    $path = $file->store('contracts', 'public');
    $url = Storage::url($path);

    // Mise à jour de l'URL dans le modèle Locataire
    $locataire = Locataire::find($request->locataire_id);
    $locataire->url_qr_code = $url;
    $locataire->save();

    return response()->json(['url' => $url], 201);
}

    public function resilier($id)
    {
        $locataire = Locataire::find($id);
        $locataire->libererUnite();
    }

    public function documentation()
    {
        $pdf = PDF::loadView("pdf.documentation");
        return $pdf->stream();
    }

    public function generatequittancelocataire($id,$token)
    {
        // Chercher le token dans la base de données pour récupérer l'utilisateur correspondant
        $accessToken = PersonalAccessToken::findToken($token);
        // Vérifier si le token est valide
        if (!$accessToken || !$accessToken->tokenable) {
            return response()->json(['message' => 'Token invalide'], 401);
        }
        // Récupérer l'utilisateur associé au token
        $user = $accessToken->tokenable;
        if ($id !== null && $user !== null) {
            $data = [];
            $quittance_locataire = CompteLocataire::where('id',$id)->where('credit','>',0)->first();
            $transactions = CompteLocataire::where('locataire_id',$quittance_locataire->locataire_id)->get();
            $locataire = Locataire::find($quittance_locataire->locataire_id);

            // Initialisation des variables des taxes
            $tom = 0;
            $cc = 0;
            $tva = 0;
            $tlv = 0;
            // Extraction des valeurs de taxes
            foreach ($locataire->locataire_taxes as $taxe) {
                switch ($taxe->taxe_id) {
                    case 1: // TVA
                        $tva = $taxe->value;
                        break;
                    case 2: // TOM
                        $tom = $taxe->value;
                        break;
                    case 3: // CH.COMM
                        $cc = $taxe->value;
                        break;
                    case 4: // TLV
                        $tlv = $taxe->value;
                        break;
                }
            }
            $tva = Taxe::where('value',$tva)->first();
            $tom = Taxe::where('value',$tom)->first();
            $tlv = Taxe::where('value',$tlv)->first();
            $montant_loyer_ttc = Outil::loyerttc($locataire->montant_loyer_ht,$tva,$tom,$tlv,$cc);
            $data['quittance'] = $quittance_locataire;
            $data['transactions'] = $transactions;
            $data['locataire'] = $locataire;
            $data['tom'] = isset($tom->value) ? $tom->value : 0;
            $data['cc'] = $cc;
            $data['tva'] = isset($tva->value) ? $tva->value : 0;
            $data['montant_ttc'] = $montant_loyer_ttc;
            $data['user'] = $user;
        //  $pdf = PDF::loadView("pdf.quittancelocataire2", $data);
            $pdf = PDF::loadView("pdf.quittancelocataire2", $data);
            $measure = array(0,0,825.772,570.197);
         return $pdf->stream();
        }else {
            return view('notfound'); // Si l'ID du locataire n'est pas fourni
        }

    }
}