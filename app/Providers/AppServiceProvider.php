<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Gate::define('admin', function (User $user){
            return $user->username == 'admin';
        });

        //Blejd direktiva zove admin koj se referencira na Gate 'admin'
        Blade::if('admin', function() {
            return request()->user()?->can('admin'); //Not quite right
        });
    }
}
