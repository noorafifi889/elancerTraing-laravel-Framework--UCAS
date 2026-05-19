<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. نتحقق أولاً إذا كانت الكاتيغوري موجودة، إذا لم تكن موجودة ننشئها
        // تم تعديل الاسم إلى categories وتعديل الـ slug إلى general ليطابق بحثك
        $category = DB::table('categories')->where('slug', 'general')->first();

        if (!$category) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => 'General',
                'slug' => 'general',
                'description' => 'Category for general-related posts.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // نحولها إلى كائن ليقرأ منها الـ id أسفل الكود
            $category = (object) ['id' => $categoryId];
        }

        // 2. إدخال المنشور الأول
        DB::table('posts')->insert([
            'user_id' => 1, // تأكدي أن جدول users فيه مستخدم id بتاعه 1
            'category_id' => $category->id,
            'title' => 'My First Post',
            'content' => 'This is the content of my first post.',
            'slug' => 'my-first-post',
            'excerpt' => 'This is the content of my first post.',
            'cover_image' => null,
            'status' => 'published',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. إدخال المنشور الثاني
        DB::table('posts')->insert([
            'user_id' => 1,
            'category_id' => $category->id,
            'title' => 'My Second Post',
            'content' => 'This is the content of my second post.',
            'slug' => 'my-second-post',
            'excerpt' => 'This is the content of my second post.',
            'cover_image' => null,
            'status' => 'published',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}