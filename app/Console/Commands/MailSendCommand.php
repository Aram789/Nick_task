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

        $websites = Website::with(['posts', 'users'])->get();

        foreach ($websites as $website){
            $website->users()->chunk(10, function ($users) use ($website) {
                foreach ($users as $user){
                    $data = [
                        'web_site_title' => $website->title,
//                            'post_title' => $post->title,
                        'email' => $user->email
                    ];
                    //$email = new SendEmailTest($data);
                    //SendEmailJob::dispatch($email);
                    $subscriberPostData = [
                        'email' => $user->email,
                        'post_id' => 1
                    ];

                    SubscriberPost::query()->create($subscriberPostData);
                }

            });
        }


    }

}
