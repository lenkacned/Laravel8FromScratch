<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create(){
        return view('register.create');
    }
    public function store(){

        // var_dump(request()->all());
        //create a user
        //postavi ogranicenja
        //vazno: ukoliok validacija padne Laravel ce nas
        //vratiti nazad na prethodnu stranu po difoltu
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:7|max:255' 
        ]);
        // $attributes['password'] = bcrypt($attributes['password']);
        $user = User::create($attributes);
        
        //log the user in
        auth()->login($user);
        
        // session()->flash('success', 'Your account has been created.');
        return redirect('/')->with('success', 'Your account has been created.');
    }
}
