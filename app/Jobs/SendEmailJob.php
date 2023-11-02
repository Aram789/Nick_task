<?php

namespace App\Jobs;

use App\Mail\SendEmailTest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SendEmailTest $emailTest;

    /**
     * Create a new job instance.
     */
    public function __construct(SendEmailTest $emailTest)
    {
        $this->emailTest = $emailTest;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to([$this->emailTest->content()->with['email']])->send($this->emailTest);
    }
}
