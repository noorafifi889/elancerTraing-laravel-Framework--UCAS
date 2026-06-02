<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        Comment::create([
            'post_id' => 1,
            'user_id' => 1,
            'content' => 'This is my first comment.',
            'user_name' => null,
        ]);
    }
}