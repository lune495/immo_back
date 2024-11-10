<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Locataire;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentReminderMail;

class SendRentReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-rent-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie de rappel de paiement pour chaque locataire';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
            // Récupérer les locataires dont l'échéance de contrat est aujourd'hui
        $locataires = Locataire::whereDate('date_echeance_contrat', Carbon::today())->get();

        // Parcourez chaque locataire et envoyez un e-mail
        foreach ($locataires as $locataire) {
            // Envoyez l'e-mail
            Mail::to($locataire->email)->send(new RentReminderMail($locataire));
        }

        $this->info('Rent reminder emails sent to tenants whose contract is due today.');
    }
}