<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $name = $this->faker->unique()->word();

        return [
            'name' => ucfirst($name), 
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
        ];
    }
}
