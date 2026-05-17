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