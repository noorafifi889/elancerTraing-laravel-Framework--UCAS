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
if ($request->hasFile('cover')) {
    $image = $request->file('cover'); // الحصول على الملف المرفوع

     $cover_image_path = $image->store('covers',['disk'=>'public']); // تخزين الصورة في مجلد 'covers' داخل التخزين العام (public
    
    
//     $image->getClientOriginalName();
//  $image->getClientOriginalName();
//  $image->getSize();
// $image->getMimeType();
}

        $request->merge([
            'user_id' => 1,
            'slug' => Str::slug($request->title), 
            'status' => 'published',
            'cover_image' => $cover_image_path ?? null, // إضافة مسار الصورة إلى البيانات المرسلة للإنشاء
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