<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CompteLocataire;
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
                    $new_compte = new CompteLocataire();
                    $new_compte->locataire_id = $dernierCompte->locataire_id;
                    $new_compte->libelle = "Loyer Dû";
                    $new_compte->dernier_date_paiement = $today;
                    $new_compte->debit = $dernierCompte->locataire->montant_loyer_ttc;
                    $new_compte->credit = 0;
                    $new_compte->statut_paye = false;
                    $new_compte->save();

                    // Envoyer un message WhatsApp
                    $message = "Bonjour ".$dernierCompte->locataire->nom .", votre loyer de " . $new_compte->debit . " est dû. Veuillez effectuer le paiement dès que possible. Merci!";
                    $this->twilioService->sendWhatsAppMessage($dernierCompte->locataire->telephone, $message);
                }
            }
         }
        return Command::SUCCESS;
    }
}