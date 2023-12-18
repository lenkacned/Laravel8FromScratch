<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index(){

        // dd(request()->user()->can('admin'))
        //ili
        //$this->authorize('admin')
      
        return view('posts.index', [
            //1. 'posts' => Post::latest()->with(['category', 'author'])->get()
            //2. 'posts' => Post::latest()->get()
            //3. 'posts' => $this->getPosts(),

            //filter - to je matoda iz query scopes-a
            //paginate je metoda iz sql query buildera
            'posts' => Post::latest()->filter(request(['search','category','author']))->paginate(3)->withQueryString(),
            //move it to categorydropdown component 
            'currentCategory' => Category::firstWhere('slug', request('category')),
            'categories' => Category::all()
        ]);
    }

    public function show(Post $post){
        return view('posts.show',[
            // 'post' => Post::findOrFail($id)
            'post' => $post,
         ]);
    }

//Moved to AdminPostsController

    //public function create(Post $post){}
    //public function store(Post $post, Request $request){}

    //We do not longer need this function 
    //instead we  'posts' => Post::latest()->filter()->get();
    // protected function getPosts(){
        //1. 
        //search the database
        // $posts = Post::latest();
        // if(request('search')){
        //     $posts
        //         ->where('title','like', '%' . request('search') . '%')
        //         ->orWhere('body','like', '%' . request('search') . '%');
        // }
        // return $post->get();

        // 2. 
        //I change all of this with query scopes:
        //i am doing this becouse queries can become more messy
        //as where and orWhere from lines up. How?
        //I create scopeFilter func in Post Model class,
        //and moved query there, and just call filter scope function. 
    
        // return Post::latest()->filter()->get();
         
    // }
}
