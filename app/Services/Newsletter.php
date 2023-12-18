<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class Newsletter{
    public function subscribe(string $email, string $list = null){
        //opcioni operator list preuzima list id iz konfiguracionog fajla
        $list ??= config('sevices.mailchimp.lists.subscribers');

        //konfigurisemo  api kljuc i server parametre za mailchamp
        //dodajemo novog clana u listu
        // return $this->client()->lists->addListMember("ce70c00c10", [
        //     'email_address' => $email,
        //     'status' => 'subscribed'
        // ]);
        //ne radi nam na ovaj nacin, kada zelimo da importujemo 
        //list_id iz .env fajla oO
        return $this->client()->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed',
        ]);
        
    }

    protected function client()
    {
        $mailchimp = new ApiClient();

        return $mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => 'us21'
        ]);
    }
}

