<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Locataire,Outil,Unite,Taxe,NotifEcheanceContrat,LocataireTaxe,BienImmo,CompteLocataire,DetailJournal,Journal,Agence,CompteCautionLocataire};
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
        //dd($request->all());
        // dd($request->nbr_mois_arriere);
        try {
            return DB::transaction(function () use ($request)
            {
                $errors =null;
                $item = new Locataire();
                // $notif = new NotifEcheanceContrat();
                $detail_journal = new DetailJournal();
                $journal = new Journal();
                $user = Auth::user();
                $array = [];
                $str_json = json_encode($request->locataire_taxes);
                $locataire_taxes = json_decode($str_json, true);

                $journal->solde = $request->montant_loyer;
                $journal->user_id = $user->id;
                $journal->save();
                // $avec_taxe = false;
                // if (!empty($request->id))
                // {
                //     $item = Locataire::find($request->id);
                // }
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
                if (empty($request->bien_immo_id))
                {
                    $errors = "Renseignez le Bien immobilier";
                }
                if (empty($request->unite_id))
                {
                    $errors = "Selectionnez un parmi les locaux disponibles";
                }
                elseif($request->statut == 'commerciale' || $request->statut == 'habitation')
                {
                $montant_loyer_ht = $request->montant_loyer;
                $montant_loyer_ttc = Outil::loyerttc($montant_loyer_ht,$locataire_taxes);
                $item->montant_loyer_ht = $request->montant_loyer;
                $item->montant_loyer_ttc = $montant_loyer_ttc;
                }else{
                    $errors = "Renseignez le type de location";
                }

                 $unite = Unite::find($request->unite_id);
                 $locataires = Locataire::where("unite_id",$request->unite_id)->get();
                 if($unite){
                    if($unite->dispo){
                        $errors = "Local occupé par un locataire";
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
                        // $item->lieu_naissance = $request->lieu_naissance;
                        // $item->date_naissance = $request->date_naissance;
                        // $item->date_delivrance = $request->date_delivrance;
                        $item->adresse_profession = $request->adresse_profession;
                        $item->situation_matrimoniale = $request->situation_matrimoniale;
                        $item->profession = $request->profession;
                        $item->telephone = $request->telephone == null ? '000000000' : $request->telephone;
                        $item->multipli = $request->multipli;
                        $item->email = $request->email;
                        $item->date_echeance_contrat = $request->date_echeance_contrat;
                        $item->unite_id = $request->unite_id;
                        $item->bien_immo_id = $request->bien_immo_id;
                        $item->cc = $request->cc;
                        $item->nbr_mois_arriere = $request->nbr_mois_arriere;
                        $item->type_location = $request->statut;
                        $item->descriptif_loyer = $request->descriptif_loyer;
                        $item->save();
                        $unite->dispo = true;
                        $unite->save();
                        $proprio_id = $item->bien_immo->proprietaire_id;
                        $id = $item->id;
                        $item->code = "L000{$id}/{$proprio_id}";
                        $saved = $item->save();

                        // Enregistrement detail_journal
                        $detail_journal->code = "JN0000{$journal->id}";
                        $detail_journal->libelle = "";
                        $detail_journal->date_location = Carbon::now();
                        $detail_journal->entree = 0;
                        $detail_journal->sortie =  0;
                        $detail_journal->locataire_id = $item->id;
                        $detail_journal->proprietaire_id = null;
                        $detail_journal->journal_id = $journal->id;
                        $detail_journal->user_id = $user->id;
                        $detail_journal->save();
                    if ($saved) {
                        // $notif->locataire_id = $id;
                        // $notif->date_echeance_contrat = $request->date_echeance_contrat;
                        // $notif->user_id = $user->id;
                        // $notif->save();
                        $caution = $request->caution;
                        $arriere = $request->nbr_mois_arriere;
                        // Vérifier si caution est un nombre
                        if (is_numeric($caution)) {
                        // Convertir caution en nombre flottant
                        $caution_num = floatval($caution);
                        }else{
                            $errors = "Format Caution Invalide";
                        }
                        $date_test = '2024-10-22 11:00:53';
                        // Assigner la valeur négative à credit
                        $compte_locataire = new CompteLocataire();
                        $compte_locataire->locataire_id = $id;
                        $compte_locataire->libelle = 'NP';
                        $compte_locataire->dernier_date_paiement = Carbon::now();
                        // $compte_locataire->dernier_date_paiement = $date_test;
                        $compte_locataire->debit = $montant_loyer_ht;
                        $compte_locataire->credit = 0;
                        $compte_locataire->statut_paye = false;
                        $compte_locataire->detail_journal_id = $detail_journal->id;
                        $compte_locataire->save();
                        if($arriere != 0){
                            // Assigner la valeur négative à credit
                            $compte_locataire = new CompteLocataire();
                            $compte_locataire->locataire_id = $id;
                            $compte_locataire->libelle = 'Arrière Paiement';
                            $compte_locataire->dernier_date_paiement = Carbon::now();
                            // $compte_locataire->dernier_date_paiement = $date_test;
                            $compte_locataire->debit = $arriere;
                            $compte_locataire->credit = 0;
                            $compte_locataire->statut_paye = false;
                            $compte_locataire->detail_journal_id = $detail_journal->id;
                            $compte_locataire->save();
                        }
                        $item->solde = $compte_locataire->debit;
                        $item->save();
                        // Compte Locataire
                        $compte_caution_locataire = new CompteCautionLocataire();
                        $compte_caution_locataire->locataire_id = $id;    
                        $compte_caution_locataire->montant_compte = $caution;
                        $compte_caution_locataire->save();
                    }
                    foreach ($locataire_taxes as $locataire_taxe) {
                        $lt = new LocataireTaxe();
                        $lt->locataire_id = $id;
                        $lt->taxe_id = $locataire_taxe['id'];
                        $lt->value = $locataire_taxe['value'];
                        $lt->save();
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
                ->whereHas('detail_journal', function ($q) {
                    $q->where('annule', false);
                })->get();
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

    public function generePDfContrat($id,$token){
         // Chercher le token dans la base de données pour récupérer l'utilisateur correspondant
         $accessToken = PersonalAccessToken::findToken($token);
         // Vérifier si le token est valide
         if (!$accessToken || !$accessToken->tokenable) {
             return response()->json(['message' => 'Token invalide'], 401);
         }
         // Récupérer l'utilisateur associé au token
         $user = $accessToken->tokenable;
        if ($id !== null && $user !== null) {
            $locataire = Locataire::find($id);
            $data['locataire'] = $locataire;
            $data['user'] = $user;
            // CIS
            if($user->structure->id == 1){
                $pdf = PDF::loadView("pdf.contratcispdflocataire", $data);
            }
            // BICO
            if($user->structure->id == 5){
                $pdf = PDF::loadView("pdf.contratbicopdflocataire", $data);
            }

            if($user->structure->id == 3){
                $pdf = PDF::loadView("pdf.contrathannepdflocataire", $data);
            }
            $measure = array(0,0,825.772,570.197);
            return $pdf->stream();
        }else {
            return view('notfound'); // Si l'ID du locataire n'est pas fourni
        }

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
            // $transactions = CompteLocataire::where('locataire_id',$quittance_locataire->locataire_id)->get();
            $locataire = Locataire::find($quittance_locataire->locataire_id);

            // $taxe = 0;
            // // Extraction des valeurs de taxes
            // foreach ($locataire->locataire_taxes as $locataire_taxe) {
            //     $taxe += $locataire_taxe->value/100;
            // }
            // $somme_tva = 1 + $taxe;
            // $montant_loyer_ttc = $locataire->montant_loyer_ht * $somme_tva;
            $data['quittance'] = $quittance_locataire;
            // $data['transactions'] = $transactions;
            $data['locataire'] = $locataire;
            // $data['montant_ttc'] = $montant_loyer_ttc;
            $data['montant_ttc'] = $locataire->montant_loyer_ttc;
            $data['user'] = $user;
        //  $pdf = PDF::loadView("pdf.quittancelocataire2", $data);
            $pdf = PDF::loadView("pdf.quittancelocataire2", $data);
            $measure = array(0,0,825.772,570.197);
         return $pdf->stream();
        }else {
            return view('notfound'); // Si l'ID du locataire n'est pas fourni
        }
    }

    public function update_notification(Request $request)
    {
        $str_json = json_encode($request->tab_notifs);
        $details = json_decode($str_json, true);
        foreach ($details as $detail) {
            $notif =  NotifEcheanceContrat::where('locataire_id',$detail['locataire_id'])->first();
            $notif->lu = true;
            $notif->save();
        }
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        try {
            return DB::transaction(function () use ($request, $id) {
                $errors = null;
                $item = Locataire::find($id);
                // $notif = NotifEcheanceContrat::where('locataire_id',$id)->get();
                
                if (!$item) {
                    $errors = "Locataire introuvable";
                }
    
                // Valider les champs nécessaires
                if (empty($request->nom)) {
                    $errors = "Renseignez le nom du locataire";
                }
                if (empty($request->prenom)) {
                    $errors = "Renseignez le prénom du locataire";
                }
                if (empty($request->type_location)) {
                    $errors = "Renseignez le type de la location Ex: Habitation/commercial";
                }
                if (empty($request->bien_immo_id)) {
                    $errors = "Renseignez le Bien immobilier";
                }
                if (empty($request->unite_id)) {
                    $errors = "Sélectionnez un parmi les locaux disponibles";
                }
                
                
                $user = Auth::user();
                $montant_loyer_ht = $request->montant_loyer;
                $locataire_taxes = json_decode(json_encode($request->locataire_taxes), true);
                $montant_loyer_ttc = Outil::loyerttc($montant_loyer_ht, $locataire_taxes);
    
                // Mettre à jour les informations du locataire
                $item->nom = $request->nom;
                $item->prenom = $request->prenom;
                $item->user_id = $user->id;
                $item->CNI = $request->cni;
                $item->adresse_profession = $request->adresse_profession;
                $item->situation_matrimoniale = $request->situation_matrimoniale;
                $item->profession = $request->profession;
                $item->telephone = $request->telephone ?? '000000000';
                $item->multipli = $request->multipli;
                $item->unite_id = $request->unite_id;
                $item->bien_immo_id = $request->bien_immo_id;
                $item->cc = $request->cc;
                $item->type_location = $request->type_location;
                $item->descriptif_loyer = $request->descriptif_loyer;
                $item->montant_loyer_ht = $montant_loyer_ht;
                $item->montant_loyer_ttc = $montant_loyer_ttc;
                $item->email = $request->email;
                $item->date_echeance_contrat = $request->date_echeance_contrat;
                $item->save();

                if ($item->save()) 
                {
                    $compte_caution_locataire =  CompteCautionLocataire::where('locataire_id',$item->id)->first();
                    $compte_caution_locataire->locataire_id = $id;    
                    $compte_caution_locataire->montant_compte = $request->caution;
                    $compte_caution_locataire->save();
                }
                // $notif->locataire_id = $item->id;
                // $notif->date_echeance_contrat = $request->date_echeance_contrat;
                // $notif->user_id = $user->id;
                // $notif->save();
                // Gestion des taxes associées (locataire_taxes)
                $existingTaxes = LocataireTaxe::where('locataire_id', $id)->get();
                // Supprimer les taxes qui ne sont plus présentes dans la requête
                foreach ($existingTaxes as $existingTax) {
                    $found = false;
                    foreach ($locataire_taxes as $tax) {
                        if ($existingTax->taxe_id == $tax['id']) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $existingTax->delete();
                    }
                }
    
                // Ajouter ou mettre à jour les taxes reçues dans la requête
                foreach ($locataire_taxes as $tax) {
                    $locataireTaxe = LocataireTaxe::where('locataire_id', $id)
                        ->where('taxe_id', $tax['id'])
                        ->first();
    
                    if ($locataireTaxe) {
                        $locataireTaxe->value = $tax['value'];
                        $locataireTaxe->save();
                    } else {
                        $newTax = new LocataireTaxe();
                        $newTax->locataire_id = $id;
                        $newTax->taxe_id = $tax['id'];
                        $newTax->value = $tax['value'];
                        $newTax->save();
                    }
                }
                
                // if (isset($errors)) {
                //     throw new \Exception($errors);
                // }
                DB::commit();
    
                return Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
            });
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
    
}