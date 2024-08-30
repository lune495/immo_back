<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuittanceLoyerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($locataire, $pdfPath)
    {
        $this->locataire = $locataire;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pdf.quittancelocataire')
                    ->subject('Votre quittance de loyer')
                    ->attach($this->pdfPath, [
                        'as' => 'quittance.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
