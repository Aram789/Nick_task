<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::query()->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request): AnonymousResourceCollection
    {
        Post::query()->create($request->validated());

        return PostResource::collection(Post::query()->paginate(15));
    }

}
