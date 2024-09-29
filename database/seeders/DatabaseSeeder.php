<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        $users = User::factory(100)->create(); // Creating 100 users

        // Create Categories
        $categories = Category::factory(50)->create(); // Creating 50 categories

        // Create Articles
        $users->each(function ($user) use ($categories) {
            Article::factory(20)->create([
                'author_id' => $user->id,
                'category_id' => $categories->random()->id,
            ]);
        });
    }
}
