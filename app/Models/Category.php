<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function posts(){
        //hasOne, hasMany, belongsTo, belongsToMany relational types Laravael has
        //Ovo je nasa druga Eloquent relationship
            return $this->hasMany(Post::class);
    }
}
