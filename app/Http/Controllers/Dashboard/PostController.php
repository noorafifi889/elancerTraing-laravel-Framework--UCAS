<?php

namespace App\Http\Controllers\Dashboard;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
    use App\Actions\FileUpload;
use App\Http\Requests\PostRequest;
    
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

     $user= Auth::user();
      $posts = $user->posts()
      ->with('category','user')
      ->select(['id', 'user_id', 'category_id', 'title','views', 'slug', 'status', 'created_at'])
      
//       ->addSelect(
//     DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comments_count')
// )
->withCount('comments') // 👈 هذا السطر يضيف عمود comments_count تلقائياً بناءً على العلاقة
      ->where('status', $status)
      ->orderBy('created_at' ,"desc")
      ->get();


        // $posts = Post::with('category')
        //              ->where('status', $status)
        //              ->latest()
        //              ->get(); 

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


public function store(PostRequest $request , FileUpload $fileUpload)
{
    // 1. التحقق من رفع الصورة وتخزينها
    // $cover_image_path = null;
    // if ($request->hasFile('cover')) {
    //     $image = $request->file('cover');
    //     $cover_image_path = $image->storePublicly('covers', 
    //     ['disk' => 'public']);
    // }

// $clean =$request->validate([
//     'title' =>'required|string|min:3|max:255',
//     'content' => 'required|string|max:99999',
//     'cover' =>[
//     'nullable',    
//     'image' ,
//     'mimes:png,jpg' ,
//      'mimetypes:image/png,image/jpeg' ,
//       'dimensions:min_width=600,min_height=400,max_width=2000,max_height=2000',
//       'max:1024'
//       ]
// ]);

$clean =$request->validated();
      // 2. دمج بيانات الفورم مع البيانات التلقائية وحفظها مباشرة
Post::create(array_merge($clean, [
    'user_id'     => auth()->id(),  // 👈 هون فقط
    'slug'        => Str::slug($request->title),
    'status'      => 'published',
    'cover_image' => $fileUpload->handle(key: 'cover', path: 'covers', disk: 'public')
]));

    return redirect()->to('/dashboard/posts')
    ->with('success', 'Post created successfully!');
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
   public function update(PostRequest $request, FileUpload $fileUpload, string $id)
{
    // 1. جلب المقال أو إرجاع 404 إذا لم يكن موجوداً
    $post = Post::findOrFail($id);

    // 2. جلب البيانات المفحوصة والمضمونة فقط من الـ Form Request
    $cleanData = $request->validated();

    // 3. معالجة الصورة: إذا رُفعت صورة جديدة نأخذ مسارها، وإلا نحتفظ بالصورة القديمة
    $cleanData['cover_image'] = $fileUpload->handle(key: 'cover', path: 'covers', disk: 'public') ?? $post->cover_image;

    // 4. تحديث بيانات المقال في قاعدة البيانات بالبيانات النظيفة فقط
    $post->update($cleanData);

    // 5. منطق حذف الصورة القديمة من السيرفر في حال تم تغييرها
    $previous = $post->getPrevious(); // تأكدي أن هذه الدالة مجهزة داخل الـ Model
    $prev_cover_image = $previous['cover_image'] ?? null;

    if ($prev_cover_image && $prev_cover_image !== $post->cover_image) {
        Storage::disk('public')->delete($prev_cover_image);
    }

    // 6. إعادة التوجيه إلى صفحة المقالات
    return redirect()->to('/dashboard/posts')->with('success', 'Post updated successfully!');
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

        return redirect()->to('/dashboard/posts')->with('success', 'Post deleted successfully!');
    }
} // 🟢 نهاية الكلاس هنا بشكل صحيح