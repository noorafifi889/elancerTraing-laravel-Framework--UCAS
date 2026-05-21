<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $post= Post::all();

    return  view('dashboard.posts.index', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     $post = new Post;
     $request->merge([
        'user_id' => 1,
        'slug' => Str::slug($request->title), 
        
        ]);
     $post =Post::create($request->all());
    //PRG =>  Post Redirect Get
    return redirect()->to('/dashboard/posts');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post= Post::find($id);
        if($post){
            abort(404);
        }
        return view('dashboard.posts.show', ['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post= Post::findOrFail($id);
        if($post){
            abort(404);
        }
        return view('dashboard.posts.edit', ['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $post = Post::findOrFail($id);
// $post->title =$request->title; 
// $post->save();
$post->update($request->all());
return redirect()->to('/dashboard/posts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        Post::destroy($id); 
        return redirect()->to('/dashboard/posts');
    }
}
