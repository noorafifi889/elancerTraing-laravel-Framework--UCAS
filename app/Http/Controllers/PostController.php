<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
protected $posts =[];
public function  __construct(){
    $this->posts = include(public_path('data/posts.php')); //include file and assign it to $posts property
}

  public function index()
{
    return view('dashboard.posts.index', [
        'posts' => $this->posts
    ]);
}

public function show(int $id, string $slug)
{
    $post = collect($this->posts)->firstWhere('id', $id);

    if (!$post) {
        abort(404);
    }

    return view('blog.single-standard', [
        'post' => $post
    ]);
}
}
