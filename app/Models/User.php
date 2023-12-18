<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Post;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //set every password before post in db as bcrypted password.
    //this function follows convection set+Attribute+Attribute
    //if you do not follow this convention it will not work
    //you can use it to capitalize all Names before save it to db
    
    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public function posts(){
        //hasOne, hasMany, belongsTo, belongsToMany relational types Laravael has
        //Ovo je nasa prva Eloquent relationship
            return $this->hasMany(Post::class);
        }
}
