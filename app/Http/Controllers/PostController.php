<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\Post\Create as CreateRequest;
use App\Http\Resources\Post\Detail as DetailResource;

class PostController extends Controller
{
    public function create(CreateRequest $request)
    {
        $post = Post::create($request->validated());

        return new DetailResource($post);
    }

    public function get(Post $post, Request $request)
    {
        return new DetailResource($post);
    }
}
