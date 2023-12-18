<?php

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use App\Services\Newsletter;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AdminPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//We almost have 7 RESTfull action:
//index, show, store, create,edit, update, destroy

Route::get('/',[PostController::class, 'index']);

Route::get('posts/{post:slug}', [PostController::class, 'show']);
//you can point to PostController and create function addComments, or you can create postcomment controller
Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

Route::post('/newsletter', NewsletterController::class);

Route::get('register' , [RegisterController::class, 'create'])->middleware('guest');
Route::post('register' , [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest');
Route::post('sessions', [SessionsController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

//Admin 

//Zato sto imamo skoro sve restfull akcije mozemo da pozovemo
//Laravel da za nas napravi sve ove endpoint za admina

// Route::post('admin/posts', [AdminPostController::class, 'store'])->middleware('can:admin');
// // Just to show how to apply middleware on group of routes
// Route::middleware('can:admin')->group(function () {
//     Route::get('admin/posts/create', [AdminPostController::class, 'create']);
//     Route::get('admin/posts', [AdminPostController::class, 'index']);
    
//     Route::get('admin/posts/{post}/edit', [AdminPostController::class, 'edit']);
//     Route::patch('admin/posts/{post}', [AdminPostController::class, 'update']);
    
//     Route::delete('admin/posts/{post}', [AdminPostController::class, 'destroy']);
    
// });

//Zato imamo help od Laravel-a:

Route::middleware('can:admin')->group(function () {
    Route::resource('admin/posts', AdminPostController::class)->except('show');
});



//Update dropdown list to be the current page and then add
//category as part of the query string in post-header file.
// no more  categories/{category:slug} route 
//now we have /?category={{$category->slug}}
//we moved our current category into index function
//
// Route::get('categories/{category:slug}', function (Category $category) {
//
//    return view('posts', [
//       'posts' => $category->posts,
//       'currentCategory' => $category,
//       'categories' => Category::all()
//      ]);
// });

//Ako stoji authors/{author} podrazumeva se da je to ID koji se prosledjuje
//I ovo smo prebacili u filter query, i u index funckiju.
// Route::get('authors/{author:username}', function (User $author) {

//    return view('posts.index', [
//       //'posts' => $author->posts->load(['category', 'author'])
//       'posts' => $author->posts,
//      ]);
// });
