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
    protected array $website;
    protected string $websiteTitle;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $lastCreatedPosts = Posts::query()->where('last_created', 0)->get();
        foreach ($lastCreatedPosts as $post) {
            $website = Website::query()->find($post->websites_id);
            $this->$website = $website;
            $this->websiteTitle = $website->title;
        }
        $this->$website->users()->chunk(10, function ($users) {
            foreach ($users as $user) {
                $data = [
                    'title' => 'A new entry has been added to the page',
                    'website_url' => $this->websiteTitle,
                    'name' => $user->name,
                    'email' => $user->email
                ];
                $email = new SendEmailTest($data);
                SendEmailJob::dispatch($email);
                Posts::query()->where('last_created', 0)->update(['last_created' => 1]);
            }
        });
    }
}
