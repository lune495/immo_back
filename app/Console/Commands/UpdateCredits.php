<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{CompteLocataire,Locataire};
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\TwilioService;

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
        // Obtenir la date actuelle
        Log::info('La commande update:credits a été déclenchée à ' . now());
        $today = Carbon::today();
        // $today = "2024-08-06 00:00:00";
        $today = \Carbon\Carbon::parse($today);
        $dayOfMonth = $today->day;
        // Exécuter la mise à jour seulement si on est le 03 du mois
        if ($dayOfMonth == 5) {
            // Récupérer tous les comptes de locataires
            $comptes = CompteLocataire::distinct('locataire_id')->pluck('locataire_id');

            foreach ($comptes as $compte) {
                // $dernierCompte = CompteLocataire::where('locataire_id', 2)
                $dernierCompte = CompteLocataire::where('locataire_id', $compte )
                                        ->where('debit',0)
                                        ->orderBy('dernier_date_paiement', 'desc')
                                        ->first();
                // Convertir la dernière date de paiement en instance de Carbon
                $dernierDate = \Carbon\Carbon::parse($dernierCompte->dernier_date_paiement);
                if ($today->greaterThanOrEqualTo($dernierDate->addMonth()->startOfMonth()->addDays(2)) && $dernierCompte->locataire->resilier == false) {
                    $compte_locataire = new CompteLocataire();
                    $compte_locataire->locataire_id = $dernierCompte->locataire_id;
                    $compte_locataire->libelle = "Loyer Dû";
                    $compte_locataire->dernier_date_paiement = $today;
                    $compte_locataire->debit = $dernierCompte->locataire->montant_loyer_ttc;
                    $compte_locataire->credit = 0;
                    $compte_locataire->statut_paye = false;
                    $compte_locataire->save();
                    $locataire = Locataire::find($compte_locataire->locataire_id);
                    $locataire->solde += $compte_locataire->debit - $compte_locataire->credit;
                    $locataire->save();
                    // Envoyer un message WhatsApp
                    // $message = "Bonjour ".$dernierCompte->locataire->nom .", votre loyer de " . $compte_locataire->debit . " est dû. Veuillez effectuer le paiement dès que possible. Merci!";
                    // $this->twilioService->sendWhatsAppMessage($dernierCompte->locataire->telephone, $message);
                }
            }
         }
        return Command::SUCCESS;
    }
}