<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        $tags = Tag::all();
        
        // 1. استعلام المقالات الأساسي
        $query = Post::query()
            ->published()
            ->with(['user', 'category']);

        // 2. التحقق من حالة تسجيل الدخول
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Tag Filter
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.slug', $request->tag);
            });
        }

        // Discover Filter
        if ($request->discover === 'popular') {
            $query->orderByDesc('views');
        } else {
            $query->latest(); 
        }

        // جلب البوست المميز بناءً على الفلترة السابقة
        $featuredPost = (clone $query)->first();

        // جلب باقي البوستات
        $posts = (clone $query)
            ->when($featuredPost, function ($q) use ($featuredPost) {
                return $q->where('id', '!=', $featuredPost->id);
            })
            ->paginate(3)
            ->withQueryString();

        return view('home', [
            'featuredPost' => $featuredPost,
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories,
        ]);
    }
}