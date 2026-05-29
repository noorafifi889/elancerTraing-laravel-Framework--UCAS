<div>
                   <a href="{{ route('posts.create') }}"
                        class="ml-2 bg-primary-container text-on-primary px-6 py-2 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all">
                        Create Post
</a>
                    <div class="ml-2 w-8 h-8">
                         <div class="w-8 h-8 rounded-full overflow-hidden border border-outline-variant cursor-pointer">
        <img alt="User Avatar" class="w-full h-full object-cover"
            src="https://ui-avatars.com/api/?name={{ $user?->name }}" />
    </div>
                    </div>
                </div>