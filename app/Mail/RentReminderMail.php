<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Locataire;

class RentReminderMail extends Mailable
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
        return $this->subject('Rappel de paiement du loyer')
                    ->view('emails.rent_reminder');
    }
}