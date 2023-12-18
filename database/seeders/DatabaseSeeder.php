<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Truncate db if you dont use migrate:fresh 
        // User::truncate();
        // Post::truncate();
        // Category::truncate();

        //Create new generic user with spec name
        $user = User::factory()->create([
            'name' => 'John Doe'
        ]);
        //Create generic post (also user and category) 
        //where user_id will be overrided with user_id of user we just created
        //Associate post with created user John Don
        Post::factory(5)->create([
            'user_id' => $user->id
        ]);

    }
}
