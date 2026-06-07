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
Route::get('/', HomeController::class)->name('home');

Route::get('/posts/{slug}', [\App\Http\Controllers\PostController::class, 'show'])
    ->name('posts.show');

// الواجهة الأمامية
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// Dashboard محمي
Route::middleware(['auth:web'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::resource('posts', PostController::class);
        Route::resource('categories', CategoryController::class);
    });

// راوتس المقالات
Route::resource('posts', PostController::class);
Route::get('/posts/{id}/{slug}', [PostController::class, 'show'])
     ->where(['id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-]+']);

     

    
Route::prefix('dashboard')->group(function () {
    
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