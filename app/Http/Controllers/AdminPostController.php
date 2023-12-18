<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Post;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Post $post, Request $request)
    {
        //ddd(request()->all());
        //ddd(request()->file('thumbnail'));

        $path = $request->file('thumbnail')->store('thumbnails/', 'public');

        //validate a post
        $attributes = $this->validatePost();

        //create a post and store it
        $attributes['user_id'] = auth()->id();
        $attributes['thumbnail'] = $path;

        Post::create($attributes);

        //redirect to post itself : TODO
        return redirect('/');
    }
     public function edit(Post $post)
    {
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post){
        //validate a post
        $attributes = $this->validatePost($post);

        if (isset($attributes['thumbnail']))
        {
            $path = $request->file('thumbnail')->store('thumbnails/', 'public');
            $attributes['thumbnail'] = $path;
        }
        $post->update($attributes);

        //create a post and store it
        $attributes['user_id'] = auth()->id();

        // return back()->with('success', 'Post Updated');
        return redirect('/admin/posts')->with('success', 'Post Updated');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Post deleted!');
    }

    protected function validatePost(?Post $post = null): array
    {
        //only reason we did this is to assist with some 
        //specialized validation rules
        $post ??= new Post();
        return request()->validate([    
        'title' => 'required',
        'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
        'slug' => ['required', Rule::unique('post','slug')->ignore($post)],
        'excerpt' => 'required',
        'body' => 'required',
        'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);
    }
}
