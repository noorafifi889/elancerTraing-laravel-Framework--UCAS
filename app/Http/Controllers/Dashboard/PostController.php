<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Actions\FileUpload;
use App\Http\Requests\PostRequest;
use App\Actions\SyncPostTags;
use App\Enum\PostStatus;
use App\Models\Category;
use App\SyncPostTags as AppSyncPostTags;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use Throwable;

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
        $status_options = array_map(function ($option) {
            return [
                'key'   => $option,
                'name'  => \Illuminate\Support\Str::ucfirst($option),
                'count' => Post::where('status', $option)->count()
            ];
        }, ['published', 'draft', 'archived']);

        $user = Auth::user();
        //  dd(Auth::check(), Auth::user());

        $posts = $user->posts()
            ->withTrashed() // 👈 هذا السطر يضمن جلب المقالات المحذوفة أيضاً
            ->with('category', 'user')
            //   ->select(['id', 'user_id', 'category_id', 'title','views', 'slug', 'status', 'created_at' , 'published_at' , 'cover_image','deleted_at'])
            ->select(['posts.*'])


            //       ->addSelect(
            //     DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comments_count')
            // )
            ->withCount('comments') // 👈 هذا السطر يضيف عمود comments_count تلقائياً بناءً على العلاقة
            ->where('status', $status)
            ->orderBy('created_at', "desc")
            ->paginate(3)
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

    public function store(PostRequest $request, FileUpload $fileUpload, AppSyncPostTags $syncPostTags)
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

        //$fileUpload = app(FileUpload::class);
        $clean = $request->validated();
        $request->post('meta.url');
        $data['content'] = strip_tags($clean['content'], '<script><h1>');

        $data = array_merge($clean, [
            'user_id' => $request->user()->id,
            'slug' => Str::slug($request->post('title')),
            'status' => 'published',
            'cover_image' => $fileUpload->handle(key: 'cover', path: 'covers'),
        ]);
        // dd($data);
        DB::beginTransaction();

        try {
            $post = Post::create($data);
            $syncPostTags->handle($post, $clean['tags'] ?? '');

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Failed to create post: ' . $e->getMessage(),
                ]);
        }

        // PRG: POST Redirect GET
        return redirect()
            ->route('posts.index')
            ->with('status', 'Post created!');
    }

    public function show(string $stug)
    {
        $post = Post::query()
            ->published()

            ->slug($stug)
            ->firstOrFail();
        if (!$post) { // 👈 تم تصحيح الشرط المقلوب ليعمل بشكل سليم
            abort(404);
        }
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $post = Post::where('user_id', Auth::id())->findOrFail($id);

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
        $data['content'] = strip_tags($cleanData['content'], '<script><h1>');
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

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        // if($post->cover_image) {
        //     Storage::disk('public')->delete($post->cover_image);
        // }

        return redirect()->to('/dashboard/posts')->with('success', 'Post deleted successfully!');
    }

    public function restore(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.index')->with('success', 'Post restored successfully!');
    }

    public function forceDelete(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        // حذف الصورة من التخزين إذا كانت موجودة
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        $post->forceDelete();

        return redirect()->route('posts.index')->with('success', 'Post permanently deleted!');
    }
}
