<?php

namespace App\Observers;
use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function creating(Post $post): void
    {
        $post->slug= Str::slug($post->title);
        $post->user_id =Auth::id();
    }


    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
    
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
if($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }    
    }
}
