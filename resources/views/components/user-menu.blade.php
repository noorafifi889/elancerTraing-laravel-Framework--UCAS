@auth
    <div class="flex items-center">
        <a href="{{ route('posts.create') }}"
           class="ml-2 bg-primary-container text-on-primary px-6 py-2 rounded-lg hover:opacity-90 transition-all">
            Create Post
        </a>

        <img class="w-8 h-8 rounded-full border ml-2"
             src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" />

        <span class="ml-2 text-sm">{{ auth()->user()->name }}</span>

        <form method="POST" action="{{ route('logout') }}" class="ml-2">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:underline">
                Logout
            </button>
        </form>
    </div>

@else
    <a href="{{ route('login') }}"
       class="ml-2 bg-primary-container text-on-primary px-6 py-2 rounded-lg hover:opacity-90 transition-all">
        Login
    </a>
@endauth