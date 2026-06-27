<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function index()
{
    $user = Auth::user();
  

    $notifications = $user->notifications()->paginate(10); 
  
    // dd([
    //     'current_user_id' => $user->id,
    //     'current_user_name' => $user->name,
    //     'all_notifications_in_db' => \Illuminate\Support\Facades\DB::table('notifications')->select('id', 'notifiable_id', 'data')->get()
    // ]);
    return view('dashboard.notifications', compact('notifications'));
}

    public function read(string $id)
    {
        $user = AUth::user();
        $notification = $user->unreadnotifications()->findOrFail($id);
        $notification->markAsRead();
return redirect()->route('notifications.index');
    }
public function unread(string $id)
{
    $user = Auth::user();
    $notification = $user->readNotifications()->findOrFail($id);
    $notification->markAsUnread(); // ✅ هيك لازم يكون
    return redirect()->route('notifications.index');
}


public function destroy(string $id) // ✅ لازم تضيف string $id
{
    $user = Auth::user();
    $notification = $user->notifications()->findOrFail($id);
    $notification->delete();
    return redirect()->route('notifications.index');
}
}
