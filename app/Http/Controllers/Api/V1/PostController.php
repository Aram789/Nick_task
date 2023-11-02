<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Posts;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PostResource::collection(Posts::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        Posts::query()->create($request->validated());

        return PostResource::collection(Posts::all());
    }

}
