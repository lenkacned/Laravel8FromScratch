<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;

class Post extends Model
{
    use HasFactory;
    public $table = 'post';
    protected $guarded = [];
    
    //Automatically load author and category with user data
    //& change boring  'posts' => Post::latest()->with(['category', 'author'])->get()
    //to 'posts' => Post::latest()->get()
    protected $with = (['category','author']);

    public function scopeFilter($query, array $filters){
        //  if($filters['search'] ?? false){
        //     $query
        //         ->where('title','like', '%' . request('search') . '%')
        //         ->orWhere('body','like', '%' . request('search') . '%');
        // }
        //Here we use query Builder function when() for
        //Appling callback's query change if the given value is true
        // also here we have null safe operator ??
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query
                ->where(fn($query)=>
                    $query
                        ->where('title','like', '%' . $search . '%')
                        ->orWhere('body','like', '%' . $search . '%')
                )
        );
                
        $query
            ->when($filters['category'] ?? false, fn($query, $category) =>
                $query
                    ->whereHas('category', fn($query)=>
                        $query
                            ->where('slug', $category)
                    )
                );
        $query
            ->when($filters['author'] ?? false, fn($query, $author) =>
                $query
                    ->whereHas('author', fn($query)=>
                    $query
                        ->where('username', $author)
                    )
            );
    }

    public function comments(){
            return $this->hasMany(Comment::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Zamenili smo user ime funkcije u author. 
    //Laraver pretpostavlja da ce foreign key biti user_id ako je ime funckije user
    //Obzirom da nama treba author moramo da navedemo realni foreigh key a to je user_id
    public function author(){
        //hasOne, hasMany, belongsTo, belongsToMany relational types Laravael has
        //Ovo je nasa prva Eloquent relationship
            return $this->belongsTo(User::class, 'user_id');
    }
}
