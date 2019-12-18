<?php

namespace App\Jobs;

use App\Mail\SendForms;
use App\Message;
use App\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $teacher;

    /**
     * Create a new job instance.
     *
     * @param Message $email
     * @param Teacher $teacher
     */
    public function __construct(Message $email, Teacher $teacher)
    {
        $this->email = $email;
        $this->teacher = $teacher;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->teacher->email)
            ->send(new SendForms($this->email, $this->teacher));
    }
}
