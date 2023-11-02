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
    public function store(SubscribeRequest $request): SubscriberResource
    {
        return new SubscriberResource(Subscribers::query()->create($request->validated()));
    }

}
