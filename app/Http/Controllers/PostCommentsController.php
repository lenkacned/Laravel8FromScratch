<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostCommentsController extends Controller
{
    public function store(Post $post)
    {
        //    dd(request()->all());

        //validation
        request()->validate([
            'body' => 'required'
        ]);

        //create post
        $post->comments()->create([
            //you can use this as:
            // 'user_id' => auth()->user()->id,
            // 'user_id' => request()->user()->id,
            // 'user_id' => auth()->id,
            // And i choose:
            'user_id' => auth()->user()->id,
            'body' => request('body'),
        ]);
        //if auth fails we will be redirected to previous page
        return back();        
    }
}
