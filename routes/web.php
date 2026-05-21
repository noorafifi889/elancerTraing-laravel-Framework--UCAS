<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\HomeController;  
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. روابط الصفحة الرئيسية للموقع
Route::view('/', 'welcome');
Route::get('/', HomeController::class)->name('home'); 

// 2. روابط الواجهة الأمامية للمقالات (الـ Blog الخارجي)
Route::get('/posts/{id}/{slug}', [PostController::class, 'show'])
     ->where(['id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-]+']);

// 3. مجموعة لوحة التحكم (Dashboard) - لتنظيم الروابط ومنع تكرار كلمة dashboard
Route::prefix('dashboard')->group(function () {
    
    // رواتس إدارة البوستات (مع الأسماء المخصصة للداشبورد تلقائياً)
    Route::resource('posts', PostController::class)->names([
        'index'   => 'posts.index',
        'create'  => 'posts.create',
        'store'   => 'posts.store',
        'show'    => 'posts.show',
        'edit'    => 'posts.edit',
        'update'  => 'posts.update',
        'destroy' => 'posts.destroy',
    ]);

    // رواتس إدارة الكاتيجوري - طلعت برا السجن وصارت نظيفة وجاهزة
    Route::resource('categories', CategoryController::class);
    
});

// 4. روت مؤقت للتست (لو حابة تفحصي الـ Create للبوستات برابط مستقل)
Route::get('/test-create-post', function() {
    $post = \App\Models\Post::create([
        'user_id'     => 1,
        'category_id' => null,
        'cover_image' => null,
        'title'       => 'Test Post From Route',
        'content'     => 'This is a test post.',
        'slug'        => 'test-post-' . time(), // عشان ما يضرب الـ Unique Slug
        'excerpt'     => 'hello world',
        'status'      => 'published'
    ]);

    dd($post);
});