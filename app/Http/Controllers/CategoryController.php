<?php 
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
public function index()
{
    // جلب الأقسام مع عدد البوستات + مجموع حقل الـ views من جدول البوستات
    $categories = Category::withCount('posts')
        ->withSum('posts as total_views', 'views') 
        ->get();
    
    $topCategory = Category::withCount('posts')
        ->withSum('posts as total_views', 'views')
        ->orderBy('posts_count', 'desc')
        ->first();

    return view('dashboard.categories.index', compact('categories', 'topCategory'));
}

    public function create()
    {
        // جلب الأقسام الرئيسية فقط في حال حبتي تعملي Dropdown للـ Parent Category مستقبلاً
        $parentCategories = Category::all(); 
        
        return view('dashboard.categories.create', compact('parentCategories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            // 'status' => 'active'
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
public function edit(Category $category)
    {
        // استدعاء ملف الـ edit وتمرير الكاتيجوري المراد تعديله له
        return view('dashboard.categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            // 'status' => 'required|in:active,archived',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            // 'status' => $request->status,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}