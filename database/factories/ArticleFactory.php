<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        $title = $this->faker->unique()->sentence();

        return [
            'author_id' => User::factory(), // Creating a user associated with the article
            'title' => $title,
            'slug' => Str::slug($title . '-' . Str::random(5)), // Generating a unique slug
            'body' => $this->faker->paragraphs(3, true),
            'excerpt' => $this->faker->text(150),
            'tags' => collect(['php', 'ruby', 'java', 'javascript', 'bash'])
                ->random(2)
                ->values()
                ->all(),
            'category_id' => Category::factory(), // Creating a category associated with the article
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'published_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'is_featured' => $this->faker->boolean(),
            'views_count' => $this->faker->numberBetween(0, 1000),
            'thumbnail' => $this->faker->optional()->imageUrl(),
            'metadata' => [
                'seo_keywords' => $this->faker->words(5, true),
                'seo_description' => $this->faker->sentence(),
            ],
        ];
    }
}
