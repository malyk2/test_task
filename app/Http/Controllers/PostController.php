<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\Post\Index as IndexRequest;
use App\Http\Requests\Post\Create as CreateRequest;
use App\Http\Resources\Post\Detail as DetailResource;
use App\Http\Resources\Post\ListItem as ListItemResource;

class PostController extends Controller
{
    public function index(IndexRequest $request)
    {
        $filter = array_filter(Arr::get($request->validated(), 'filter', []));

        $posts = Post::filter($filter)->latest()->get();

        return ListItemResource::collection($posts);
    }

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
