<?php

namespace App\Http\Controllers;

use App\Events\PostViewed;
use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
protected $posts =[];
public function  __construct(){
    $this->posts = include(public_path('data/posts.php')); //include file and assign it to $posts property
}

public function index()
{
    $posts = Post::query()->published()->get();    
    return view('posts.index',['posts' => $posts]); 
}

public function show(string $slug)
{

    // return"test";
   $post=  Post::query()->where('slug',$slug)->first();
//    event('posts.viewed' , $post);
event(new PostViewed($post));
//    $post->increment('views');
    return view('posts.show', [
        'post' => $post
    ]);
}



}
