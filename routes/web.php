
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\HomeController;  
use App\Http\Controllers\CategoryController;
// روابط الصفحة الرئيسية
Route::view('/', 'welcome');
Route::get('/', HomeController::class)->name('home'); 

// هيرووو! هذا السطر الواحد يعوضك عن الـ 8 أسطر المكررة ويمنحك الأسماء التي تريدها تلقائياً
Route::resource('dashboard/posts', PostController::class)->names([
    'index'   => 'posts.index',
    'create'  => 'posts.create',
    'store'   => 'posts.store',
    'show'    => 'posts.show',
    'edit'    => 'posts.edit',
    'update'  => 'posts.update',
    'destroy' => 'posts.destroy',
]);

// anther way to write routes without using resource
// Route::post('/dashboard/posts', [PostController::class, 'store']);
// Route::get('/dashboard/posts/{id}', [PostController::class, 'show']);
// Route::get('/dashboard/posts/{id}/edit', [PostController::class, 'edit']);
// Route::put('/dashboard/posts/{id}', [PostController::class, 'update']);
// Route::delete('/dashboard/posts/{id}', [PostController::class, 'destroy']);



Route::get('/posts/{id}/{slug}',[PostController::class,'show'])
     ->where(
        ['id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-]+']
     )
; //callable code

Route::get('/posts',function(){
// $post=App\Models\Posts::query()->
//       where("ststus" ,"=" ,"published")->
//     get();

$post=App\Models\Post::create(
      [
         'user_id' => 1,
         'title' => 'Test Post',
         'content' => 'This is a test post.',
         'slug' => 'test-post',
         'cover_image' => null,
         'status' => 'published',
         'views' => 0,
      ]
   );
});
; //callable code 



Route::get('/posts', function(){
    $posts = \App\Models\Post::create([
      'user_id'=>1,
      'category_id'=>null ,
      'cover_image'=>null ,
      'title'=>'Test Post',
      'content'=>'This is a test post.',
      'slug'=>'third-post',
      'excerpt'=>'hello world',
      'status'=> 'published'


    ]);


Route::prefix('dashboard')->group(function () {
    
    // 1. رواتس إدارة البوستات (Resource لجميع العمليات: index, create, store, edit, update, destroy)
    Route::resource('posts', PostController::class);

    // 2. رواتس إدارة الكاتيجوري (Resource الكامل لعمليات الـ CRUD)
    Route::resource('categories', CategoryController::class);
    
});

    dd($posts);
   //  \App\Models\Post::query()
   //  ->where('status','=', 'published')
   //  ->get();
   //  dd($posts);
});