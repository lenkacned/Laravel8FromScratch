<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Services\Newsletter;

//this is a single action controller 
//that means that it have just one function-action
//so in a route file we dont need to specify an action.
class NewsletterController extends Controller
{
    public function __invoke(Newsletter $newsletter)
    {
        request()->validate(['email' => 'required|email']);
    
        try{
            
            $newsletter->subscribe(request('email'));
    
        } catch (Exception $e){
            
            throw ValidationException::withMessages([
                'email' => 'This email could not be added to our newsletter list.'
            ]);
    
        }
        //Get list id on https://mailchimp.com/developer/marketing/api/file-manager-folders/
        // $response = $mailchimp->lists->getList("ce70c00c10");
        // ddd($response);
        return redirect('/')
                ->with('success', 'You are now signed up for our newsletter!');
    }
}
