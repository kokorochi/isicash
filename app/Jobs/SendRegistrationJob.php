<?php

namespace App\Jobs;

use App\Mail\RegistrationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $recipients, $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipients, $email)
    {
        $this->recipients = $recipients;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->recipients != '' && $this->recipients != null)
        {
            Mail::to($this->recipients)->send(new RegistrationEmail($this->email));
        }
    }
}
