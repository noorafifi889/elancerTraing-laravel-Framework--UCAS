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
        return view('dashboard.notifications', ['notifications' => $user->notifications()->paginate()]);
    }


    public function read(string $id)
    {
        $user = AUth::user();
        $notification = $user->unreadnotifications()->findOrFail($id);
        $notification->markAsRead();
        return  redirect()->route('dashboard.notifications.index');
    }
      public function unread(string $id)
    {
        $user = AUth::user();
        $notification = $user->readnotifications()->findOrFail($id);
        $notification->markAsRead();
        return  redirect()->route('dashboard.notifications.index');
    }  

    public  function destroy(){
          $user = AUth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();
        return  redirect()->route('dashboard.notifications.index');
    }
}
