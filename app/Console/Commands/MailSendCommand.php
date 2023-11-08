<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Mail\SendEmailTest;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\SubscriberPost;
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
        $createdAt = SubscriberPost::query()->orderBy('created_at', 'DESC')->pluck('created_at')->first();
        $posts = Post::query()->where('created_at', '>=', $createdAt)->get();

        foreach ($posts as $post) {
            $website = $post->website;

            $website->users()->chunk(10, function ($users) use ($website, $post) {
                foreach ($users as $user) {
                    $data = [
                        'web_site_title' => $website->title,
                        'post_title' => $post->title,
                        'email' => $user->email
                    ];

                    $email = new SendEmailTest($data);
                    SendEmailJob::dispatch($email);

                    $subscriberPostData = [
                        'email' => $user->email,
                        'post_id' => $post->id
                    ];
                    SubscriberPost::query()->create($subscriberPostData);
                }
            });
        }

    }

}
