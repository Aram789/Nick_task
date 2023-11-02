<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Mail\SendEmailTest;
use App\Models\Posts;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MailSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'app:mail-send-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $lastCreatedPosts = Posts::query()->where('last_created', 0)->get();

        foreach ($lastCreatedPosts as $post) {
            $website = Website::query()->where('id', $post->websites_id)->first();
            $website->users()->chunk(10, function ($users) use ($website, $post) {
                foreach ($users as $user) {
                    $data = [
                        'web_site_title' => $website->title,
                        'post_title' => $post->title,
                        'email' => $user->email
                    ];
                    $email = new SendEmailTest($data);
                    SendEmailJob::dispatch($email);
                    Posts::query()->where('last_created', 0)->update(['last_created' => 1]);
                }
            });
        }
    }
}
