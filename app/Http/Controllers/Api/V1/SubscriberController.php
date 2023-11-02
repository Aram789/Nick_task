<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscribers;

class SubscriberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscribeRequest $request): SubscriberResource|\Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        $exist = Subscribers::query()->where([
            'user_id' => $validatedData['user_id'],
            'websites_id' => $validatedData['websites_id']
        ])->exists();

        return $exist ?
            response()->json(['message' => 'Already exist']) :
            new SubscriberResource(Subscribers::query()->create($validatedData));
    }

}
