<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{CompteLocataire, Locataire,Journal,DetailJournal};
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentReminderMail;
use App\Mail\RappelEcheanceContrat;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UpdateCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:credits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update credits for tenants based on last payment date and rent amount';

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        parent::__construct();
        $this->twilioService = $twilioService;
    }

    public function handle()
    {
        try {
        
        return DB::transaction(function ()
        {
        // Obtenir la date actuelle
        Log::info('La commande update:credits a été déclenchée à ' . now());
        $today = Carbon::today();
        $dayOfMonth = $today->day;
        $detail_journal = new DetailJournal();
        $journal = new Journal();
        // dd($today);
        // Récupérer tous les comptes de locataires
        $comptes = CompteLocataire::distinct('locataire_id')->pluck('locataire_id');
        foreach ($comptes as $compteId) {
            $dernierCompte = CompteLocataire::where('locataire_id', $compteId)
            // $dernierCompte = CompteLocataire::where('locataire_id', 2)
                // ->where('credit','>','0')
                ->orderBy('dernier_date_paiement', 'desc')
                ->first();
            // Convertir la dernière date de paiement en instance de Carbon
            $dernierDate = Carbon::parse($dernierCompte->dernier_date_paiement);
            $locataire = Locataire::find($compteId);
            // $today = "2024-11-12 00:00:00";
            $today = Carbon::parse($today);
            // dd($dernierDate);
            // Vérifier si le locataire appartient à la structure_id = 2 c-a-d AdajImmo
            if ($locataire->user->structure->id == 2) {
                // dd($dernierCompte);
                // Vérifier si on dépasse un mois et 2 jours depuis le dernier paiement
                if ($today->greaterThanOrEqualTo($dernierDate->addMonth()) && $dayOfMonth > 10 && $locataire->resilier == false) {
                    // Calculer le nombre de jours de retard depuis le 10 du mois
                    $daysLate = $dayOfMonth - 10; 
                    
                    // Appliquer la pénalité de 2500 XOF pour chaque jour de retard
                    if ($daysLate > 0) {
                        $journal->solde = $locataire->montant_loyer_ht;
                        // $journal->user_id = $user->id;
                        $journal->save();
                        // Enregistrement detail_journal
                        $detail_journal->code = "JN0000{$journal->id}";
                        $detail_journal->libelle = "";
                        $detail_journal->date_location = "";
                        $detail_journal->entree = 0;
                        $detail_journal->sortie =  0;
                        $detail_journal->locataire_id = $item->id;
                        $detail_journal->proprietaire_id = null;
                        $detail_journal->journal_id = $journal->id;
                        $detail_journal->user_id = $user->id;
                        $detail_journal->save();
                        $compte_locataire = new CompteLocataire();
                        $compte_locataire->locataire_id = $locataire->id;
                        $compte_locataire->libelle = "Pénalité pour retard - Jour " . $dayOfMonth;
                        $compte_locataire->dernier_date_paiement = $today;
                        $compte_locataire->debit = 2500; // Pénalité fixe de 2500 XOF
                        $compte_locataire->credit = 0;
                        $compte_locataire->statut_paye = false;
                        $compte_locataire->detail_journal_id = $detail_journal->id;
                        $compte_locataire->save();

                        // Mettre à jour le solde du locataire
                        $locataire->solde += 2500;
                        $locataire->save();

                        if($locataire->date_echeance_contrat->isSameDay(Carbon::today())){
                            Mail::to($locataire->email)->send(new RappelEcheanceContrat($locataire));
                        }
                        Mail::to($locataire->email)->send(new RentReminderMail($locataire));
                        // Log pour la pénalité appliquée
                        Log::info("Une pénalité de retard de 2500 XOF a été appliquée pour le locataire {$locataire->id} pour le jour {$dayOfMonth}.");
                    }
                }
            } 
            // Pour les locataires de la structure 1
            else if ($locataire->user->structure->id != 2) {
                // dd($dayOfMonth);
                // Si la date est supérieure ou égale à la dernière date de paiement plus 1 mois et 2 jours, appliquer le loyer dû
                if ($today->greaterThanOrEqualTo($dernierDate->addDays(5)) && $locataire->resilier == false) {
                // if ($dayOfMonth == 1 && $locataire->resilier == false) {
                    $solde = round($locataire->montant_loyer_ht);
                    $journal->solde = $solde;
                    // $journal->user_id = $user->id;
                    $journal->save();
                    $detail_journal->code = "JN0000{$journal->id}";
                    $detail_journal->libelle = "";
                    $detail_journal->date_location = Carbon::now();
                    $detail_journal->entree = 0;
                    $detail_journal->sortie =  0;
                    $detail_journal->locataire_id = $locataire->id;
                    $detail_journal->proprietaire_id = null;
                    $detail_journal->journal_id = $journal->id;
                    // $detail_journal->user_id = $user->id;
                    $detail_journal->save();
                    $compte_locataire = new CompteLocataire();
                    $compte_locataire->locataire_id = $locataire->id;
                    $compte_locataire->libelle = "Loyer Dû";
                    $compte_locataire->dernier_date_paiement = Carbon::now();
                    $compte_locataire->debit = $locataire->montant_loyer_ht;
                    $compte_locataire->credit = 0;
                    $compte_locataire->statut_paye = false;
                    $compte_locataire->detail_journal_id = $detail_journal->id;
                    $compte_locataire->save();

                    // Mettre à jour le solde du locataire
                    $locataire->solde += $compte_locataire->debit - $compte_locataire->credit;
                    $locataire->save();
                    // Envoie du mail pour la date d'echeance de son contrat
                    if($locataire->date_echeance_contrat){
                        $date_echeance = Carbon::parse($locataire->date_echeance_contrat);
                        if($date_echeance->isSameDay(Carbon::today())){
                            Mail::to($locataire->email)->send(new RappelEcheanceContrat($locataire));
                        }
                    }
                    //envoie du mail pour le rappel de paiement 
                    Mail::to($locataire->email)->send(new RentReminderMail($locataire));
                    // Envoyer un message WhatsApp si nécessaire
                    // $message = "Bonjour " . $locataire->nom . ", votre loyer de " . $compte_locataire->debit . " est dû. Veuillez effectuer le paiement dès que possible. Merci!";
                    // $this->twilioService->sendWhatsAppMessage($locataire->telephone, $message);
                }
            }
        }
        DB::commit();
        return Command::SUCCESS;
        });

        } catch (exception $e) {            
                DB::rollback();
                return $e->getMessage();
        }
        
    }
}