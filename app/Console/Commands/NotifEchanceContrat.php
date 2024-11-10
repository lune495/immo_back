<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{NotifEcheanceContrat,Locataire};
use Carbon\Carbon;

class NotifEchanceContrat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:echance-contrat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $locataires = Locataire::all();
        foreach ($locataires as $locataire) {
            if($locataire->date_echeance_contrat) {
                $date_echeance = Carbon::parse($locataire->date_echeance_contrat);
    
                // Vérifier si la date d'échéance est aujourd'hui
                if($date_echeance->isSameDay(Carbon::today())) {
                    
                    // Vérifier si une notification pour ce locataire et pour aujourd'hui existe déjà
                    $existeDeja = NotifEcheanceContrat::where('locataire_id', $locataire->id)
                        ->whereDate('date_echeance_contrat', Carbon::today())
                        ->exists();
    
                    if (!$existeDeja) {
                        $notif = new NotifEcheanceContrat();
                        $notif->locataire_id = $locataire->id;
                        $notif->date_echeance_contrat = Carbon::today();
                        $notif->user_id = $locataire->user->id;
                        $notif->lu = false;
                        $notif->save();
                    }
                }
            }
        }
        return 0;
    }
}