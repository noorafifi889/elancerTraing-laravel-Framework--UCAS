<x-layout title="Create Post">
<form action="{{ $action ??  route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- <input type="hidden" name="_method" value="put"> //method spoofing for updatehod  --}}
    @method($method ?? 'POST')

            <main class="pt-24 pb-32 flex flex-col md:flex-row max-w-container-max mx-auto px-gutter gap-12">
            <!-- Editor Canvas -->
            <div class="flex-1 max-w-article-max mx-auto w-full distraction-free-focus">
                <div class="editor-container">
                    <!-- Title Field -->
<input 
    type="text"
    name="title"
    value="{{ $post->title ?? '' }}" 
    class="w-full bg-transparent border-none focus:ring-0 font-display-lg text-display-lg placeholder:text-surface-variant text-on-surface mb-8" 
    placeholder="Enter your title..." 
/>

<input 
    type="text"
    name="content"
    value="{{ $post->content ?? '' }}" 
    class="w-full bg-transparent border-none focus:ring-0 font-body-lg text-body-lg placeholder:text-surface-variant text-on-surface leading-relaxed"
    placeholder="Type your story..." 
/>
                    <!-- Floating Toolbar (Contextual) -->
                    {{-- <div class="sticky top-20 z-40 flex justify-center mb-12">
                        <div
                            class="bg-inverse-surface text-inverse-on-surface px-2 py-1.5 rounded-xl shadow-xl flex items-center gap-1 border border-outline/20">
                            <button class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Bold">
                                <span class="material-symbols-outlined">format_bold</span>
                            </button>
                            <button class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Italic">
                                <span class="material-symbols-outlined">format_italic</span>
                            </button>
                            <div class="w-px h-6 bg-white/10 mx-1"></div>
                            <button class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Heading 1">
                                <span class="material-symbols-outlined">format_h1</span>
                            </button>
                            <button class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Heading 2">
                                <span class="material-symbols-outlined">format_h2</span>
                            </button>
                            <div class="w-px h-6 bg-white/10 mx-1"></div>
                            <button class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Quote">
                                <span class="material-symbols-outlined">format_quote</span>
                            </button>
                            <button class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Link">
                                <span class="material-symbols-outlined">link</span>
                            </button>
                            <div class="w-px h-6 bg-white/10 mx-1"></div>
                            <button class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Image">
                                <span class="material-symbols-outlined">image</span>
                            </button>
                        </div>
                    </div>
                    <!-- Main Content Editor -->
                    <div class="w-full min-h-[614px] bg-transparent border-none focus:outline-none font-body-lg text-body-lg text-on-surface leading-relaxed placeholder:text-surface-variant"
                        contenteditable="true" data-placeholder="Type your story...">
                        <p class="mb-6">It began as a simple thought—a flicker of ink on a pristine digital canvas.
                            The rhythm of the keys creates a cadence, a quiet symphony of creation that exists only
                            between the writer and the paper.</p>
                        <p class="mb-6">In this space, distraction falls away. The borders of the interface recede,
                            leaving only the words. We prioritize clarity above all else, ensuring that every sentence
                            has room to breathe and every idea has the weight it deserves.</p>
                    </div> --}}
                    {{-- <input type='text'
                    {{-- value ="{{ $post->contant }}" --}}
                    {{-- name="content"
                        class="w-full bg-transparent border-none focus:ring-0 font-body-lg text-body-lg resize-none placeholder:text-surface-variant text-on-surface leading-relaxed"
                      placeholder="Type your story..."
                      /> --}} 

                      <button type="submit" class="mt-6 bg-primary-container text-on-primary px-6 py-2 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all">
                        Publish
                    </button>
                </div>
            </div>
            <!-- Sidebar: Publishing Settings -->
            <aside
                class="hidden lg:block w-80 shrink-0 h-fit sticky top-24 sidebar-overlay transition-opacity duration-500">
                <div class="space-y-8 border-l border-outline-variant pl-8">
                    <!-- Cover Image -->
                    <section>
                        <h3 class="font-ui-label text-ui-label text-on-surface mb-4 uppercase tracking-wider">Cover
                            Image</h3>
                        <div
                            class="aspect-video w-full rounded-lg bg-surface-container border-2 border-dashed border-outline-variant flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-surface-container-high transition-colors group">
                            <span
                                class="material-symbols-outlined text-secondary group-hover:text-primary transition-colors">add_a_photo</span>
                            <span class="font-metadata text-metadata text-secondary">Upload high-res photo</span>
                        </div>
                        <input type='file' name="cover_image" accept="image/png, image/jpeg ,image/jpg" />
                    </section>
                    <!-- Tags -->
                    <section>
                        <div class="space-y-2">
    <label for="category_id" class="text-sm font-medium">Category</label>
    <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
        <option value="">Select a Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" 
                {{ (old('category_id', $post->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
                    </section>
                    <!-- SEO Preview -->
                    <section>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-ui-label text-ui-label text-on-surface uppercase tracking-wider">SEO Preview
                            </h3>
                            <button class="text-primary font-metadata text-metadata hover:underline">Edit</button>
                        </div>
                        <div class="p-4 bg-white border border-outline-variant rounded-lg shadow-sm">
                            <div class="text-[#1a0dab] font-sans text-[18px] leading-tight mb-1 truncate">The Art of
                                Digital Quiet | Ink &amp; Paper</div>
                            <div class="text-[#006621] font-sans text-[14px] mb-1 truncate">inkandpaper.com/art-of-quiet
                            </div>
                            <p class="text-secondary font-sans text-[13px] line-clamp-2">Discover how a distraction-free
                                writing environment can transform your creative process and help you find your voice in
                                a noisy world...</p>
                        </div>
                    </section>
                    <!-- Visibility -->
                    <section class="pt-4 border-t border-outline-variant">
                        <label class="flex items-center justify-between cursor-pointer group">
                            <span
                                class="font-ui-label text-ui-label text-secondary group-hover:text-on-surface transition-colors">Public
                                Post</span>
                            <div class="relative inline-flex items-center">
                                <input checked="" class="sr-only peer" type="checkbox" />
                                <div
                                    class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                </div>
                            </div>
                        </label>
                    </section>
                </div>
            </aside>
        </main>
    </form>
    </x-layout>