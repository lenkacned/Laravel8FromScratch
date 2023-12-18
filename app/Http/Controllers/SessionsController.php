<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{

    public function create(){
        return view('sessions.create');
    } 

    public function destroy(){
        auth()->logout();
        return redirect('/')->with('success', 'Goodbye!');
    }

    public function store(){
        //validate the request
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]); 
        //attemp to authenticate and log in the user 
        //based on the provided credentials
        //attemp funkcija vas sigin-uje 
        //ali takodje proverava da li je sifra za usera dobra
        if(auth()->attempt($attributes)){
            //session fication as web attack tecnique
            session()->regenerate();
            return redirect('/')->with('success','Welcome Back!');
        }
        //auth failed
        //one way:
        return back()
            ->withInput()
            ->withErrors(['email' => 'Your provided credentials could not be verified.']);
        //the other way:
        throw ValidationException::withMessages([
            'email' => 'Your provided credentials could not be verified'
        ]);
    }
}

