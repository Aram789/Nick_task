<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscribeRequest $request)
    {
        $validatedData = $request->validated();

        $exist = Subscriber::query()->where([
            'user_id' => $validatedData['user_id'],
            'website_id' => $validatedData['website_id']
        ])->exists();

        return $exist ?
            response()->json(['message' => 'Already exist']) :
            new SubscriberResource(Subscriber::query()->create($validatedData));
    }

}
