<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(5, true),
            'excerpt' => fake()->sentence(10),
            'slug' => fake()->unique()->slug(),
            'cover_image' => null,
            'status' => 'published',
            'views' => fake()->numberBetween(0, 1000),
            'published_at' => now(),
            'meta' => null,
        ];
    }
}