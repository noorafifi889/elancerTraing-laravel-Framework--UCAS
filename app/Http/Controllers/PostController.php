<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
protected $posts =[];
public function  __construct(){
    $this->posts = include(public_path('data/posts.php')); //include file and assign it to $posts property
}
public function index(Request $request) // تم تعديل إملاء Request
{  
    $status = $request->query('status', 'published');

    $status_options = array_map(function($option) {
        return [
            'key'   => $option,
            'name'  => ucfirst($option),
            'count' => Post::where('status', $option)->count() // تم إصلاح قوس الإغلاق الزائد هنا
        ];
    }, ['published', 'draft', 'archived']);

    $posts = Post::where('status', $status)
                 ->latest() // أضفنا الترتيب الزمني بناءً على طلبك السابق
                 ->get(); 

    // 4. تمرير البيانات المنظمة إلى صفحة الـ Blade
    return view('dashboard.posts.index', [
        'posts'          => $posts,
        // 'current_status' => $status,
'status_options' => $status_options
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
