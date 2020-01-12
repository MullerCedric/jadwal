<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use App\Preference;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use PDF;

class PreferenceModified extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    protected $fileName;
    public $username;
    public $preference;

    /**
     * Create a new message instance.
     *
     * @param Preference $preference
     * @param $username
     */
    public function __construct(Preference $preference, $username)
    {
        $pdfController = new PdfController();
        $this->pdf = base64_encode($pdfController->preferenceToPDF($preference)->output());
        $updatedAt = Carbon::now()->format('d-m-y');
        $this->fileName = 'preferences-' . $updatedAt . '-' . $preference->examSession->slug . '.pdf';

        $this->username = $username;
        $this->preference = $preference;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Vos préférences ont été modifiées')
            ->markdown('emails.preference.modified')
            ->attachData(base64_decode($this->pdf), $this->fileName, [
                'mime' => 'application/pdf',
            ]);
    }
}
