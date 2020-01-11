<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use App\Preference;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class PreferenceCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @param Preference $preference
     */
    public function __construct(Preference $preference)
    {
        $pdfController = new PdfController();
        $this->pdf = base64_encode($pdfController->preferenceToPDF($preference)->output());
        $this->name = 'preferences-' . $preference->examSession->slug . '.pdf';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Vos préférences ont été envoyées')
            ->markdown('emails.preference.created')
            ->attachData(base64_decode($this->pdf), $this->name, [
                'mime' => 'application/pdf',
            ]);
    }
}
