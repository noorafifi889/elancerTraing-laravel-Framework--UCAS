<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {  
        // 1. استقبال الـ status من الـ Query String (الرابط)، والافتراضي هو published
        $status = $request->query('status', 'published');

        // 2. بناء مصفوفة الخيارات (Tabs) لفلترة الحالات مع حساب العدد من الداتابيز
        $status_options = array_map(function($option) {
            return [
                'key'   => $option,
'name'  => \Illuminate\Support\Str::ucfirst($option),
                'count' => Post::where('status', $option)->count()
            ];
        }, ['published', 'draft', 'archived']);

        $posts = Post::with('category')
                     ->where('status', $status)
                     ->latest()
                     ->get(); 

        return view('dashboard.posts.index', [
            'posts'          => $posts,
            'current_status' => $status,
            'status_options' => $status_options
        ]);
    }
    /**
     * Show the form for creating a new resource.
*/
public function create()
{
    // 1. جلب كل التصنيفات
    $categories = Category::all();
    
    // 2. إنشاء كائن فارغ من الـ Post (عشان لو الفورم بتستخدمه للكارنيه أو الـ Old data)
    $post = new Post();

    // 3. تمرير المتغيرين معاً داخل دالة compact واحدة ونظيفة
    return view('dashboard.posts.create', compact('categories', 'post'));
}


public function store(Request $request)
{
    // 1. التحقق من رفع الصورة وتخزينها
    $cover_image_path = null;
    if ($request->hasFile('cover')) {
        $image = $request->file('cover');
        $cover_image_path = $image->storePublicly('covers', 
        ['disk' => 'public']);
    }

    // 2. دمج بيانات الفورم مع البيانات التلقائية وحفظها مباشرة
    Post::create(array_merge($request->all(), [
        'user_id'     =>  1, // يفضل استخدام auth()->id() وتجعل 1 كاحتياطي
        'slug'        => Str::slug($request->title), 
        'status'      => 'published',
        'cover_image' => $cover_image_path,
    ]));

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
 if($request->hasFile('cover')) {
            $image = $request->file('cover');
            $cover_image_path = $image->storePublicly('covers', ['disk' => 'public']);
            $request->merge(['cover_image' => $cover_image_path]);
        }   
        $post->update($request->except(['_method','_token']));
$previous=  $post->getPrevious();
$prev_cover_image =$previous['cover_image'] ?? null;
if($prev_cover_image !== $post->cover_image){
    Storage::disk('public')->delete($prev_cover_image);
}
        return redirect()->to('/dashboard/posts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        
if($post->cover_image) {
    Storage::disk('public')->delete($post->cover_image);
}

        return redirect()->to('/dashboard/posts');
    }
} // 🟢 نهاية الكلاس هنا بشكل صحيح