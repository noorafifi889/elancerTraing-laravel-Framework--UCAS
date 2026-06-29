<x-layout title="Home" main-style="pt-10 pb-section-gap max-w-container-max mx-auto px-gutter grid grid-cols-1 md:grid-cols-12 gap-8">
<x-slot:style>
        <style>
            .article-column {
                max-width: 720px;
            }
            /* إضافة هيدينج توب لأن الهيدر fixed حتى لا يغطي المحتوى */
            body { padding-top: 64px; } 
        </style>
    </x-slot:style>


        <aside class="hidden md:block md:col-span-2 space-y-8">
            <div class="space-y-4">
                <h3 class="font-ui-label text-ui-label uppercase tracking-widest text-secondary font-bold">Discover</h3>
                <ul class="space-y-2">
                    <li><a class="flex items-center gap-3 text-primary font-bold font-ui-label text-ui-label py-1"
                            href="#"><span class="material-symbols-outlined" data-weight="fill"
                                style="font-variation-settings: 'FILL' 1;">explore</span>Explore</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-primary transition-colors font-ui-label text-ui-label py-1"
                            href="#"><span class="material-symbols-outlined">trending_up</span>Popular</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-primary transition-colors font-ui-label text-ui-label py-1"
                            href="#"><span class="material-symbols-outlined">history</span>Recent</a></li>
                </ul>
            </div>
            <div class="space-y-4">
                <h3 class="font-ui-label text-ui-label uppercase tracking-widest text-secondary font-bold">Your Tags
                </h3>
                <div class="flex flex-wrap gap-2">
                    <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                        href="#">#Development</a>
                    <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                        href="#">#DesignSystems</a>
                    <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                        href="#">#Minimalism</a>
                    <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                        href="#">#Typography</a>
                    <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                        href="#">#Future</a>
                </div>
            </div>
        </aside>
        <!-- Center Feed -->
        <section class="col-span-1 md:col-span-7 space-y-12">
            <!-- Featured Article (Bento Style) -->
@if($featuredPost)
                          <article
                class="group border border-outline-variant rounded-xl overflow-hidden bg-white hover:border-primary transition-colors duration-300">
                <div class="aspect-[16/9] overflow-hidden">
                    <img alt=""
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        data-alt="A macro photograph of high-quality cream-colored paper with deep black ink strokes, showcasing fine texture and professional calligraphy. The lighting is soft and cinematic, casting gentle shadows that emphasize the physical depth of the ink on the page. The overall aesthetic is minimalist and sophisticated, representing a premium editorial experience with high contrast and clarity."
                        src={{ asset('storage/' . $featuredPost->cover_image) }}" />
                </div>
                <div class="p-8 space-y-4">
                    <div class="flex items-center gap-3 font-metadata text-metadata text-secondary">
                        <span
                            class="bg-primary-container text-on-primary px-2 py-0.5 rounded font-bold uppercase tracking-wider">Featured</span>
                        <span>•</span>
                        <span>May 12, 2024</span>
                        <span>•</span>
                        <span>8 min read</span>
                    </div>
                    <h2
                        class="font-headline-md text-headline-md text-on-surface leading-tight group-hover:text-primary transition-colors">
                      {{ $featuredPost->title }}</h2>
                    <p class="text-on-surface-variant font-body-md text-body-md line-clamp-3">
                     {{$featuredPost->content}}
                        .</p>
                    <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant overflow-hidden">
                                <img alt="Author" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDlYHQ2yPKl-Weyq3JRVjhy936Wd9AaAVvFRAHsIQrKrnCv4i5A-cQ6YF0zqrKz1Ma7N9cW9R6NimpSIUyDmkSyzdN0Sf4wwyS7Jf5Iq_UrWBpwB9MPN5QGbUNdxa82Mz2YU2I0GnXGjM6DDPi-mIODcm-LUOTsZb-C7V1GgUyP3AvuztsY0A5OKbR2TsqCVVxpF70-TiHMB2Jsyd2ojVnbA0gj9jJ03QY9BqD7puDZnBBYI5PyKBtwtQiGWMcknmNIjCWUWokSAMSR" />
                            </div>
                            <div>
                                <p class="font-ui-label text-ui-label font-bold text-on-surface">{{$featuredPost->user->name }}</p>
                                <p class="font-metadata text-metadata text-secondary">Design Principal</p>
                            </div>
                        </div>
                        <button class="text-primary p-2 rounded-full hover:bg-primary-container/10 transition-colors">
                            <span class="material-symbols-outlined" data-icon="bookmark_add">bookmark_add</span>
                        </button>
                    </div>
                </div>
            </article>
@endif  
            <!-- Grid of Regular Articles -->
            <div class="grid grid-cols-1 gap-12">
@forelse ($posts as $post)
    <article class="flex flex-col md:flex-row gap-8 group">
        <!-- صورة المقال -->
        <div class="w-full md:w-1/3 aspect-video md:aspect-square overflow-hidden rounded-lg border border-outline-variant">
            <img alt="{{ $post->title }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                 src="{{ asset('storage/' . $featuredPost->cover_image) }}" /> 
                 <!-- 💡 استبدلي image_url بالحقل الصحيح للصورة لديكِ أو اتركي الرابط الافتراضي -->
        </div>

        <!-- تفاصيل المقال -->
        <div class="w-full md:w-2/3 space-y-3">
            <div class="flex items-center gap-2 font-metadata text-metadata text-secondary">
                <!-- اسم القسم (Category) -->
                <span class="text-primary font-bold">{{ $post->category->name ?? 'Uncategorized' }}</span>
                <span>•</span>
                <!-- تاريخ النشر -->
                <span>{{ $post->created_at->format('M d, Y') }}</span>
            </div>

            <!-- عنوان المقال -->
            <h3 class="font-headline-md text-[24px] leading-snug text-on-surface group-hover:text-primary transition-colors">
                <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
            </h3>

            <!-- محتوى المقال (مختصر) -->
            <p class="text-on-surface-variant font-body-md text-body-md line-clamp-2">
                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}
            </p>

            <div class="flex items-center gap-3 pt-2">
                <!-- اسم الكاتب (User) -->
                <p class="font-ui-label text-ui-label text-on-surface font-medium">{{ $post->user->name ?? 'Unknown Author' }}</p>
                <span class="text-secondary text-metadata">•</span>
                <!-- عدد المشاهدات أو وقت القراءة (مثال استرشادي) -->
                <span class="text-secondary font-metadata text-metadata">{{ $post->views ?? 0 }} views</span>
            </div>
        </div>
    </article>
@empty
    <!-- رسالة تظهر فقط إذا لم يكن هناك أي مقالات أخرى -->
    <div class="text-center py-8 text-on-surface-variant">
        <p>لا توجد مقالات إضافية متاحة حالياً.</p>
    </div>
@endforelse

<!-- تأكدي من إضافة روابط التنقل بين الصفحات (Pagination Links) أسفل الحلقة -->
<div class="mt-8">
    {{ $posts->links() }}
</div>
                <!-- Article 2 -->
           
                <!-- Article 3 -->
         
            </div>
            <div class="pt-8 flex justify-center">
                <button
                    class="px-8 py-3 border border-primary text-primary font-ui-button text-ui-button rounded-lg hover:bg-primary-container/5 transition-all">
                    Load More Stories
                </button>
            </div>
        </section>
        <!-- Right Sidebar: Trending & Who to Follow -->
        <aside class="hidden lg:block lg:col-span-3 space-y-12">
            <!-- Trending Section -->
            @include('asides.Trending')
            <!-- Who to Follow -->
            {{-- <x-recommended-authors title= "Followers" count="3" /> --}}
<x-recommended-authors title="Followers" count="3" />            <!-- Newsletter Sign Up -->
            <x-widgets.newslatter>
                <x-slot:helper>
                    <h1> hello world</h1>
                </x-slot:helper>
                <button
                    class="w-full py-2 bg-white text-primary font-ui-button text-ui-button rounded hover:bg-opacity-90 transition-all">Subscribe</button>
            </x-widgets.newslatter>
            {{-- @include('asides.Newsletter') --}}
        </aside>


    @section('nav')
        @parent
        <a class="text-primary font-bold border-b-2 border-primary pb-1 font-ui-label text-ui-label hover:text-primary transition-colors duration-200"
            href="#">child</a>
    @endsection
</x-layout>
