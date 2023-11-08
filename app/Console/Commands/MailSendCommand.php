<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Mail\SendEmailTest;
use App\Models\Post;
use App\Models\SubscriberPost;
use App\Models\Website;
use Illuminate\Console\Command;

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

        if (isset($createdAt)) {
            $posts = Post::query()->where('created_at', '>=', $createdAt)->get();
        } else {
            $posts = Post::query()->get();
        }

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
