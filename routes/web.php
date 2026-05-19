<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;  

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'welcome');


Route::get('/',HomeController::class)->name('home'); //callable code 

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
    dd($posts);
   //  \App\Models\Post::query()
   //  ->where('status','=', 'published')
   //  ->get();
   //  dd($posts);
});