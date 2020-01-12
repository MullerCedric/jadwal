<?php

namespace App\Jobs;

use App\Mail\PreferenceModified;
use App\Preference;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PreferenceModifiedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $preference;
    protected $username;

    /**
     * Create a new job instance.
     *
     * @param Preference $preference
     * @param $username
     */
    public function __construct(Preference $preference, $username)
    {
        $this->preference = $preference;
        $this->username = $username;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $preferenceMailable = new PreferenceModified($this->preference, $this->username);
        Mail::to($this->preference->teacher)->send($preferenceMailable);
    }
}
