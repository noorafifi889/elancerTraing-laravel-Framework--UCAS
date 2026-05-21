<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

use App\Models\Category;
use Illuminate\Support\Str;

 

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {  
        $status = $request->query('status', 'published');

        $status_options = array_map(function($option) {
            return [
                'key'   => $option,
                'name'  => ucfirst($option),
                'count' => Post::where('status', $option)->count() 
            ];
        }, ['published', 'draft', 'archived']);

        $posts = Post::where('status', $status)
                     ->latest() 
                     ->get(); 

        return view('dashboard.posts.index', [
            'posts'          => $posts,
            'current_status' => $status, // 👈 فككت التعليق عنها لأن الـ Blade يحتاجها للتحديد الأزرق!
            'status_options' => $status_options
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
return view('dashboard.posts.create', compact('categories'),
        $post= new Post() 
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'user_id' => 1,
            'slug' => Str::slug($request->title), 
            'status' => 'published',
        ]);

        Post::create($request->all());

        return redirect()->to('/dashboard/posts');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) { // 👈 تم تصحيح الشرط المقلوب ليعمل بشكل سليم
            abort(404);
        }
        return view('dashboard.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
$categories = Category::all();
    return view('dashboard.posts.edit', compact('post', 'categories')); 
       }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
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
        
        return redirect()->to('/dashboard/posts');
    }
} // 🟢 نهاية الكلاس هنا بشكل صحيح