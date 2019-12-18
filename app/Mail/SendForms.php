<?php

namespace App\Mail;

use App\Message;
use App\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendForms extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $email, Teacher $teacher)
    {
        $this->email = $email;
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->email->title)
            ->markdown('emails.send-forms');
    }
}
