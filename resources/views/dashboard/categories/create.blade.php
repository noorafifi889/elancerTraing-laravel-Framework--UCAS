<x-layout>
    <div class="max-w-3xl mx-auto my-12 px-4" dir="ltr">
        
        <div class="mb-6">
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 transition-colors font-medium">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to Categories
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 sm:p-8 border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Create New Category</h1>
                <p class="text-sm text-gray-500 mt-1">Add a new core segment to refine your content structure.</p>
            </div>

            <form action="{{ $action ?? route('categories.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf
                  @method($method ?? 'POST')
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Category Name <span class="text-red-500">*</span></label>
                        <span class="text-xs text-gray-400 font-normal">Required</span>
                    </div>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
value="{{ old('name', $category->name ?? '') }}"
                            placeholder="e.g., Technology, Lifestyle, Business" 
                            class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100/50 transition-all outline-none font-medium @error('name') border-red-500 bg-red-50/10 @enderror"
                            required
                        >
                    </div>
                    @error('name')
                        <p class="text-red-600 text-xs font-medium flex items-center gap-1 mt-1">
                            <span class="material-symbols-outlined text-sm">error</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="description" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</label>
                        <span class="text-xs text-gray-400 font-normal">Optional</span>
                    </div>
                    <textarea 
                        id="description"
                        name="description" 
                        rows="5" 
                        placeholder="Provide a brief summary or editorial intent for this category to assist with SEO..." 
                        class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100/50 transition-all outline-none text-sm leading-relaxed resize-none"
              >{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('categories.index') }}" 
                       class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-all">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">done</span>
                        Publish Category
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-layout>