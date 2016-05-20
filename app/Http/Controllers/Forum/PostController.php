<?php

namespace Forum\Http\Controllers\Forum;

use Forum\Http\Requests;
use Illuminate\Http\Request;
use Forum\Http\Controllers\Controller;
use Forum\Http\Requests\Forum\CreatePostFormRequest;

class PostController extends Controller
{
    public function store(CreatePostFormRequest $request, Topic $topic)
    {
        $post = $topic->posts()->create([
            'body' => $request->input('body'),
            'user_id' => $request->user()->id,
        ]);

        // return redirect('home');
    }
}