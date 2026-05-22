<x-layout>


    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-sm mt-10" dir="ltr">
        <!-- Header -->
        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Create New Category</h1>
                <p class="text-sm text-gray-500 mt-1">Set up a new section to organize your products or content
                    seamlessly.</p>
            </div>
            <button class="text-sm text-blue-600 hover:underline">← Back to Categories</button>
        </div>

        <!-- Form -->
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Left Side: Basic Info -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" placeholder="e.g., Electronics, Fashion..."
                            class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug (URL-friendly)</label>
                        <input type="text" placeholder="e.g., electronics-appliances"
                            class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-600 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parent Category</label>
                        <select
                            class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none appearance-none bg-white">
                            <option>None (Main Category)</option>
                            <option>Home Appliances</option>
                            <option>Clothing & Apparel</option>
                        </select>
                    </div>
                </div>

                <!-- Right Side: Media & Details -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category Image</label>
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 cursor-pointer transition-colors">
                            <span class="text-gray-500 block text-sm">Drag & drop your image here, or <span
                                    class="text-blue-600 font-medium">browse</span></span>
                            <span class="text-xs text-gray-400 block mt-1">PNG, JPG up to 2MB</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea rows="3" placeholder="Write a short description for SEO purposes..."
                            class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                </div>

            </div>

            <!-- Actions Buttons -->
            <div class="flex items-center justify-end gap-3 border-t pt-4 mt-6">
                <button type="button"
                    class="px-5 py-2.5 border rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="button"
                    class="px-5 py-2.5 border rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Save as
                    Draft</button>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">Publish
                    Category</button>
            </div>
        </form>
    </div>

</x-layout>
