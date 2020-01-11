<?php

namespace App\Jobs;

use App\Mail\PreferenceCreated;
use App\Preference;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PreferenceCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $preference;

    /**
     * Create a new job instance.
     *
     * @param Preference $preference
     */
    public function __construct(Preference $preference)
    {
        $this->preference = $preference;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $preferenceMailable = new PreferenceCreated($this->preference);
        Mail::to($this->preference->teacher)->send($preferenceMailable);
    }
}
