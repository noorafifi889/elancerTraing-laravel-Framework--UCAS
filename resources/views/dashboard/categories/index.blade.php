<x-layout>


        <main class="pt-24 pb-section-gap px-gutter max-w-container-max mx-auto">
            <!-- Header Section -->
            <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div class="max-w-2xl">
                    <h1 class="font-display-lg text-display-lg text-on-surface mb-2">Category Management</h1>
                    <p class="font-body-md text-on-surface-variant">Organize your content structure, monitor performance
                        metrics, and refine your editorial taxonomy for maximum audience engagement.</p>
                </div>
                <a  href="{{ route('categories.create') }}"
                    class="bg-primary text-on-primary px-6 py-3 rounded-lg font-ui-button text-ui-button shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-2 whitespace-nowrap">
                    <span class="material-symbols-outlined">add</span>
                    Create Category
            </a>
            </header>
            <!-- Search and Layout Toggle -->
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-8">
                <div class="relative w-full md:w-96">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input
                        class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl pl-12 pr-4 py-3 font-ui-label text-ui-label focus:border-primary outline-none transition-all"
                        placeholder="Filter categories by name..." type="text" />
                </div>
                <div class="flex items-center gap-2 bg-surface-container-low p-1 rounded-lg">
                    <button class="p-2 bg-surface-container-lowest text-primary rounded shadow-sm">
                        <span class="material-symbols-outlined">grid_view</span>
                    </button>
                    <button class="p-2 text-on-surface-variant">
                        <span class="material-symbols-outlined">list</span>
                    </button>
                </div>
            </div>
            <!-- Category Grid (Asymmetric Bento-inspired layout) -->
         <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
    
    @if($topCategory)
    <div class="md:col-span-8 bg-surface-container-lowest border border-outline-variant rounded-xl p-8 hover:border-primary transition-colors group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <span class="text-primary font-bold text-sm tracking-widest uppercase mb-2 block">Top Performing</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">{{ $topCategory->name }}</h2>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('categories.edit', $topCategory->id) }}" class="p-2 hover:bg-surface-variant rounded transition-colors text-on-surface-variant" title="Edit">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    <form action="{{ route('categories.destroy', $topCategory->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 hover:bg-surface-variant rounded transition-colors text-on-surface-variant" title="Delete">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <p class="font-metadata text-metadata text-on-surface-variant uppercase mb-1">Posts</p>
                    <p class="font-headline-md text-2xl font-bold">{{ $topCategory->posts_count }}</p>
                </div>
             <div>
    <p class="font-metadata text-metadata text-on-surface-variant uppercase mb-1">Views</p>
    <p class="font-headline-md text-2xl font-bold">
        {{ $topCategory->total_views ?? 0 }}
    </p>
</div>
                <div>
                    <p class="font-metadata text-metadata text-on-surface-variant uppercase mb-1">Avg. Read</p>
                    <p class="font-headline-md text-2xl font-bold">--</p>
                </div>
                <div>
                    <p class="font-metadata text-metadata text-on-surface-variant uppercase mb-1">Growth</p>
                    <p class="font-headline-md text-2xl font-bold text-green-600">--</p>
                </div>
            </div>
            <div class="flex items-center gap-4 pt-6 border-t border-outline-variant">
                <span class="font-ui-label text-ui-label text-on-surface-variant">Active since {{ $topCategory->created_at->format('M Y') }}</span>
            </div>
        </div>
    </div>
    @endif

    @foreach($categories as $category)
        {{-- نتخطى طباعة القسم الأعلى أداءً هنا لأنه مطبوع بالفعل في الكارد الكبير فوق --}}
        @if($topCategory && $category->id === $topCategory->id) @continue @endif

        <div class="md:col-span-4 bg-surface-container-lowest border border-outline-variant rounded-xl p-8 hover:border-primary transition-colors flex flex-col justify-between group relative">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <h2 class="font-headline-md text-2xl font-bold text-on-surface">{{ $category->name }}</h2>
                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('categories.edit', $category->id) }}" class="text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-on-surface-variant hover:text-error transition-colors bg-transparent border-none cursor-pointer">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="font-body-md text-on-surface-variant text-base mb-6 line-clamp-2">
                    {{ $category->description ?? 'No description provided.' }}
                </p>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-on-surface-variant text-sm">article</span>
                    <span class="font-ui-label text-ui-label">{{ $category->posts_count ?? 0 }} Posts</span>
                </div>
            </div>
        </div>
    @endforeach

    <a href="{{ route('categories.create') }}"
        class="md:col-span-4 bg-surface-container-lowest border border-outline-variant rounded-xl p-8 border-dashed flex flex-col items-center justify-center text-center opacity-60 hover:opacity-100 hover:bg-surface-container-low transition-all cursor-pointer">
        <div class="w-12 h-12 rounded-full border border-outline-variant flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-on-surface-variant">add</span>
        </div>
        <p class="font-ui-label text-ui-label text-gray-900 font-semibold">Add Category Idea</p>
        <p class="font-metadata text-metadata text-on-surface-variant mt-1">Draft a new category skeleton</p>
    </a>

</div>
            <!-- Table View For Bulk Actions (Secondary Section) -->
            <section class="mt-20">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-8">All Categories</h3>
                <div class="overflow-x-auto bg-surface-container-lowest border border-outline-variant rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th
                                    class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider">
                                    Category Name</th>
                                <th
                                    class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider">
                                    Post Count</th>
                                <th
                                    class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider">
                                    Total Views</th>
                                <th
                                    class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider text-right">
                                    Actions</th>
                            </tr>
                        </thead>
               <tbody class="divide-y divide-outline-variant">
    @forelse($categories as $category)
        <tr class="hover:bg-surface transition-colors">
            <td class="px-6 py-4">
                <div class="font-headline-md text-xl font-bold">{{ $category->name }}</div>
                <div class="font-metadata text-metadata text-on-surface-variant">
                    /categories/{{ $category->slug }}
                </div>
            </td>

            <td class="px-6 py-4">
                @if($category->status === 'active' || $category->status === 'published')
                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-bold uppercase tracking-wider">Active</span>
                @else
                    <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded text-xs font-bold uppercase tracking-wider">Draft</span>
                @endif
            </td>

            <td class="px-6 py-4 font-ui-label text-ui-label">
                {{ $category->posts_count ?? 0 }}
            </td>

<td class="px-6 py-4 font-ui-label text-ui-label">
    {{ $category->total_views ?? 0 }}
</td>
            <td class="px-6 py-4 text-right">
                <div class="flex justify-end gap-2">
                    <a href="{{ route('categories.edit', $category->id) }}" class="text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    
                    <a href="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-on-surface-variant hover:text-error transition-colors bg-transparent border-none cursor-pointer">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </a>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-6 py-10 text-center font-metadata text-on-surface-variant">
                No categories available. Create your first category to get started!
            </td>
        </tr>
    @endforelse
</tbody>
                    </table>
                </div>
            </section>
        </main>
   

</x-layout>
