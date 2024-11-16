<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

use App\Exports\DatasExport;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use MPDF;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Mail;
use App\Mail\Maileur;

class Outil extends Model
{

    public static $queries = array(
        "proprietaires"              =>  " id,code,nom,prenom,telephone,user{id,name},bien_immos{id,code,adresse,description},cgf,foncier_bati",
        "locataires"                 =>  " id,code,lieu_naissance,date_naissance,date_delivrance,caution,type_location,solde,url_qr_code,unite{numero,dispo,nature_local{id,nom},etage,superficie_en_m2,annee_achevement,nombre_piece_principale,nombre_salle_de_bain,type_localisation,balcon},cni,adresse_profession,profession,situation_matrimoniale,nom,prenom,telephone,montant_loyer_ttc,montant_loyer_ht,descriptif_loyer,bien_immo_id,bien_immo{id,code,description,proprietaire_id,proprietaire{id,code,cgf,nom,prenom,telephone}},locataire_taxes{locataire{id,nom,prenom},taxe{id,nom,value}}",
        "users"                      =>  " id,name,email,role{id,nom}",
        "bien_immos"                 =>  " id,code,commission_agence,nom_immeuble,nbr_dispo,adresse,description,nbr_etage,nbr_total_appartement,nbr_magasin,proprietaire_id,proprietaire{id,cgf,code,nom,prenom,telephone},locataires{id,code,solde,url_qr_code,nom,prenom,telephone},unites{numero,dispo,nature_local{id,nom},etage,locataires{nom,prenom,solde,resilier},superficie_en_m2,annee_achevement,nombre_piece_principale,nombre_salle_de_bain,type_localisation,balcon}",
        "unite"                      =>  " id,numero,dispo,nature_local{id nom},locataires{nom,prenom,solde,resilier},type_localisation,etage,bien_immo{id,code,nom_immeuble,proprietaire{id,code,cgf,nom,prenom}},superficie_en_m2,annee_achevement,nombre_piece_principale,nombre_salle_de_bain,balcon",
        "taxes"                      =>  " id,nom,value",
        "nature_locations"           =>  " id,nom",
        "journals"                   =>  " id,solde,detail_journals{libelle,code,entree,sortie,proprietaire_id,proprietaire{id,code,nom,cgf},locataire_id,locataire{id,solde,code,url_qr_code,cni,adresse_profession,situation_matrimoniale,nom,prenom,bien_immo{id,code,description,proprietaire_id,proprietaire{id,code,cgf,nom,prenom,telephone}}}}",
        "detail_journals"            =>  " id,code,annule,libelle,user{id,name},entree,sortie,created_at_fr,updated_at_fr,locataire_id,proprietaire_id,proprietaire{id,code,cgf},journal_id,journal{id solde},locataire{id,solde,url_qr_code,code,cni,adresse_profession,situation_matrimoniale,nom,prenom,bien_immo{id,code,description,proprietaire_id,proprietaire{id,code,cgf,nom,prenom,telephone}}}",
        "journal_proprios"           =>  " id,solde,libelle,entree,sortie,locataire_id,proprietaire_id,locataire{id,solde,url_qr_code,code,cni,adresse_profession,situation_matrimoniale,nom,prenom,bien_immo{id,code,description,proprietaire_id,proprietaire{id,code,cgf,nom,prenom,telephone}}}",
        "type_bien_immos"            =>  " id,nom,bien_immos{id,code,adresse,description,locataires{id,solde,url_qr_code,code,nom,prenom,telephone,montant_loyer_ttc,montant_loyer_ht,descriptif_loyer}}",
        // "proprio_bien_immos"      =>  " id,user_id,user{id,name,email,role{id,nom}},proprietaire_id,proprietaire{id,code,nom,prenom,telephone,agence_id,agence{id,nom_agence}},bien_immo_id,bien_immo{id,code,description,montant}",
    );

    public static function redirectgraphql($itemName, $critere,$liste_attributs)
    {
        $path='{'.$itemName.'('.$critere.'){'.$liste_attributs.'}}';
        return redirect('graphql?query='.urlencode($path));
    }
    public static function loyerht($montant_loyer_ttc,$tva,$tom,$tlv,$cc)
    {
       // Calculer la somme des taux de taxes en pourcentage
        $tva_rate = $tva ? $tva->value / 100 : 0;
        $tom_rate = $tom ? $tom->value / 100 : 0;
        $tlv_rate = $tlv ? $tlv->value / 100 : 0;
        $cc_rate = $cc ? $cc / 100 : 0;

        // Calculer le total des taux de taxes
        $total_taxes_rate = $tva_rate + $tom_rate + $tlv_rate + $cc_rate;

        // Calculer le montant HT
        $loyer_ht = $montant_loyer_ttc / (1 + $total_taxes_rate);

        return $loyer_ht;
    }

    public static function loyerttc($montant_loyer_ht,$locataire_taxes)
    {
        $taxe = 0;
        // dd($locataire_taxes);
        foreach ($locataire_taxes as $locataire_taxe) {
            $taxe += $locataire_taxe['value']/100;
        }
        $somme_tva = 1 + $taxe;
        $loyer_ttc = $montant_loyer_ht * $somme_tva;
        return $loyer_ttc;
    }

    public static function getResponseError(\Exception $e)
    {
        return response()->json(array(
            'errors'          => [config('env.APP_ERROR_API') ? $e->getMessage() : config('env.MSG_ERROR')],
            'errors_debug'    => [$e->getMessage()],
            'errors_line'    => [$e->getLine()],
        ));
    }
    public static function getOneItemWithGraphQl($queryName, $id_critere, $justone = true)
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'defaults' => [
                'exceptions' => true
            ]
        ]);

        $critere = (is_numeric($id_critere)) ? "id:{$id_critere}" : $id_critere;
        $queryAttr = Outil::$queries[$queryName];
        $apiUrl = self::getAPI(); // Utilisation de l'URL dynamique
        $response = $guzzleClient->get("{$apiUrl}/graphql?query={{$queryName}({$critere}){{$queryAttr}}}");
        $data = json_decode($response->getBody(), true);
        return ($justone) ? $data['data'][$queryName][0] : $data;
    }
    public static function getItemWithGraphQl($queryName, $start,$end, $justone = true)
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'defaults' => [
                'exceptions' => true
            ]
        ]);
        $critere = "created_at_start:\"{$start}\",created_at_end:\"{$end}\"";
        $queryAttr = Outil::$queries[$queryName];
        $apiUrl = self::getAPI(); // Utilisation de l'URL dynamique
        $response = $guzzleClient->get("{$apiUrl}/graphql?query={{$queryName}({$critere}){{$queryAttr}}}",[
                'headers' => [
                'Authorization' => "Bearer {$token}",
                'Accept'        => 'application/json',
            ]
        ]);
        //dd("{$apiUrl}/graphql?query={{$queryName}({$critere}){{$queryAttr}}}");
        $data = json_decode($response->getBody(), true);
        $start = date("d/m/y",strtotime($start));
        $end = date("d/m/y",strtotime($end));
        $data['detail_journals'] = $data['data']['detail_journals'];
        $data['start'] = $start;
        $data['end'] = $end;
        // dd($data);
        return $data;
    }

    public static function getItemSituationProprioWithGraphQl($queryName, $start = null, $end = null, $proprioId, $justone = true)
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'defaults' => [
                'exceptions' => true
            ]
        ]);
    
        // Créer le critère avec ou sans dates
        $critere = "proprio_id_entree:{$proprioId}";
        if ($start && $end) {
            $critere .= ",created_at_start:\"{$start}\",created_at_end:\"{$end}\"";
        }
        
        $queryAttr = Outil::$queries[$queryName];
        $apiUrl = self::getAPI(); // Utilisation de l'URL dynamique
    
        $response = $guzzleClient->get("{$apiUrl}/graphql?query={{$queryName}({$critere}){{$queryAttr}}}");
        $data = json_decode($response->getBody(), true);
        
        return $data;
    }
    
    public static function getAPI()
    {
        return config('env.APP_URL');
    }
    public static function getNbLocataireActif()
    {
        $locataire_actif = Locataire::where('resilier', false)->count();
        return $locataire_actif;
    }

    public static function getNbLocataireRetard($proprietaireId=null)
    {
        $query = Locataire::where('solde', '>', 0);

        if ($proprietaireId !== null) {
            // Récupérer les IDs des biens immobiliers appartenant au propriétaire
            $bien_immo_ids = BienImmo::where('proprietaire_id', $proprietaireId)
                                     ->pluck('id')
                                     ->toArray();
            $query->whereIn('bien_immo_id', $bien_immo_ids);
        }
    
        if ($month !== null && $year !== null) {
            // Filtrer les locataires créés dans le mois et l'année spécifiés
            $query->whereMonth('created_at', $month)
                  ->whereYear('created_at', $year);
        }
    
        return $query->count();
    }
    public static function formatdate()
    {
        return "Y-m-d H:i:s";
    }

    public static function toutEnMajuscule($val)
    {
        return strtoupper($val);
    }
    
    public static function premereLettreMajuscule($val)
    {
        return ucfirst($val);
    }
    //Formater le prix
    public static function formatPrixToMonetaire($nbre, $arrondir = false, $avecDevise = false)
    {
        //Ajouté pour arrondir le montant
        if ($arrondir == true) {
            // $nbre = Outil::enleveEspaces($nbre);
            $nbre = round($nbre);
        }
        $rslt = "";
        $position = strpos($nbre, '.');
        if ($position === false) {
            //---C'est un entier---//
            //Cas 1 000 000 000 Ã  9 999 000
            if (strlen($nbre) >= 9) {
                $c = substr($nbre, -3, 3);
                $b = substr($nbre, -6, 3);
                $d = substr($nbre, -9, 3);
                $a = substr($nbre, 0, strlen($nbre) - 9);
                $rslt = $a . ' ' . $d . ' ' . $b . ' ' . $c;
            } //Cas 100 000 000 Ã  9 999 000
            elseif (strlen($nbre) >= 7 && strlen($nbre) < 9) {
                $c = substr($nbre, -3, 3);
                $b = substr($nbre, -6, 3);
                $a = substr($nbre, 0, strlen($nbre) - 6);
                $rslt = $a . ' ' . $b . ' ' . $c;
            } //Cas 100 000 Ã  999 000
            elseif (strlen($nbre) >= 6 && strlen($nbre) < 7) {
                $a = substr($nbre, 0, 3);
                $b = substr($nbre, 3);
                $rslt = $a . ' ' . $b;
                //Cas 0 Ã  99 000
            } elseif (strlen($nbre) < 6) {
                if (strlen($nbre) > 3) {
                    $a = substr($nbre, 0, strlen($nbre) - 3);
                    $b = substr($nbre, -3, 3);
                    $rslt = $a . ' ' . $b;
                } else {
                    $rslt = $nbre;
                }
            }
        } else {
            //---C'est un décimal---//
            $partieEntiere = substr($nbre, 0, $position);
            $partieDecimale = substr($nbre, $position, strlen($nbre));
            //Cas 1 000 000 000 Ã  9 999 000
            if (strlen($partieEntiere) >= 9) {
                $c = substr($partieEntiere, -3, 3);
                $b = substr($partieEntiere, -6, 3);
                $d = substr($partieEntiere, -9, 3);
                $a = substr($partieEntiere, 0, strlen($partieEntiere) - 9);
                $rslt = $a . ' ' . $d . ' ' . $b . ' ' . $c;
            } //Cas 100 000 000 Ã  9 999 000
            elseif (strlen($partieEntiere) >= 7 && strlen($partieEntiere) < 9) {
                $c = substr($partieEntiere, -3, 3);
                $b = substr($partieEntiere, -6, 3);
                $a = substr($partieEntiere, 0, strlen($partieEntiere) - 6);
                $rslt = $a . ' ' . $b . ' ' . $c;
            } //Cas 100 000 Ã  999 000
            elseif (strlen($partieEntiere) >= 6 && strlen($partieEntiere) < 7) {
                $a = substr($partieEntiere, 0, 3);
                $b = substr($partieEntiere, 3);
                $rslt = $a . ' ' . $b;
                //Cas 0 Ã  99 000
            } elseif (strlen($partieEntiere) < 6) {
                if (strlen($partieEntiere) > 3) {
                    $a = substr($partieEntiere, 0, strlen($partieEntiere) - 3);
                    $b = substr($partieEntiere, -3, 3);
                    $rslt = $a . ' ' . $b;
                } else {
                    $rslt = $partieEntiere;
                }
            }
            if ($partieDecimale == '.0' || $partieDecimale == '.00' || $partieDecimale == '.000') {
                $partieDecimale = '';
            }
            $rslt = $rslt . '' . $partieDecimale;
        }
        if ($avecDevise == true) {
            $formatDevise = Outil::donneFormatDevise();
            $rslt = $rslt . '' . $formatDevise;
        }
        return $rslt;
    }
    public static function donneFormatDevise()
    {
        $retour = ' F CFA';
        return $retour;
    }

    public static function getOperateurLikeDB()
    {
        return config('database.default')=="mysql" ? "like" : "ilike";
    }
}
/*select * from reservations where programme_id in (select id from programmes where id=1112 and ((quotepart_pourcentage is not null && quotepart_pourcentage!=0) or (quotepart_valeur is not null && quotepart_valeur!=0)));*/
