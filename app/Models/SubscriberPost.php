<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriberPost extends Model
{
    protected $fillable = [
        'email',
        'post_id'
    ];
}
