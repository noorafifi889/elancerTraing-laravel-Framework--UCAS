<?php

namespace App\Listeners;

use App\Events\PostViewed;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class IncrementPostViews
{


    public function __construct() {}

    public function handle(PostViewed $event): void
    {
        // 1. جلب الكوكي (بدون unserialize)
        $cookieValue = Cookie::get('post-views');

        // 2. فك الـ JSON (إذا كان موجوداً)، وإلا ابدئي بمصفوفة فارغة
        $postViews = $cookieValue ? json_decode($cookieValue, true) : [];

        // تأمين: تأكدي دائماً أنها مصفوفة
        if (!is_array($postViews)) {
            $postViews = [];
        }

        // 3. التحقق باستخدام المفتاح (أسرع وأدق)
        if (array_key_exists($event->post->id, $postViews)) {
            return;
        }

        // 4. إضافة المقال للمصفوفة
        $postViews[$event->post->id] = true;

        // 5. حفظ الكوكي بصيغة JSON (مدة 1440 دقيقة = 24 ساعة)
        Cookie::queue('post-views', json_encode($postViews), 1440);

        // 6. زيادة العداد
        $event->post->increment('views');
    }
}
