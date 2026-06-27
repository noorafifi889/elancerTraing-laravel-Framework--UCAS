<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotification;
use App\Mail\GreetingMessage;
use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class FollowController extends Controller
{
public function store(Request $request, string $id)
{
    $user = User::findOrFail($id); // الشخص الذي سيتم متابعته
    $follower = $request->user();   // الشخص الذي يقوم بالمتابعة

    $exists = $follower->followings()
        ->whereKey($user->id)
        ->exists();

if (!$exists && $follower->id != $user->id) {
    $follower->followings()->attach($user->id, [
        'created_at' => now(),
    ]);

    // ✅ نرسل فقط الـ $follower (أنت) إلى حساب الشخص الآخر ($user)
    $user->notify(new FollowNotification($follower));

}


    return redirect()->back();
}
public function destroy(Request $request, string $id)
{
    $user = User::findOrFail($id);
    $follower = $request->user();

    $follower->followings()->detach($user->id);

    return redirect()->back();
}
}