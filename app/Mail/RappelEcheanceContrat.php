<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Locataire;

class RappelEcheanceContrat extends Mailable
{
    use Queueable, SerializesModels;

    public $locataire;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Locataire $locataire)
    {
        $this->locataire = $locataire;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rappel de renouvellement de contrat')
                    ->view('emails.rappel_echeance');
    }
}