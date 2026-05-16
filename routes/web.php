<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'welcome');


Route::get('/posts',[PostController::class,'index']); //callable code 

Route::get('/posts/{id}/{slug}',[PostController::class,'show'])
     ->where(
        ['id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-]+']
     )
; //callable code