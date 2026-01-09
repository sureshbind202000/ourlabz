<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Index 
    public function index()
    {
        // sendNotification(
        //     78,
        //     'lab-registration',
        //     [
        //         'lab_name'  => 'New Lab name',
        //         'user_name' => 'New Lab User',
        //         'date'      => now()->format('d M Y'),
        //     ]
        // );

        return view('backend.superadmin.notifications.list');
    }

    // List
    public function list()
    {
        $notifications = Auth::user()->notifications;
        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $notificationIds = $request->ids;
        Auth::user()->notifications()->whereIn('id', $notificationIds)->update(['read_at' => now()]);
        return response()->json(['success' => 'Notifications marked as read']);
    }

    // Delete a single or multiple notifications
    public function deleteNotification(Request $request)
    {
        $notificationIds = $request->ids;
        Auth::user()->notifications()->whereIn('id', $notificationIds)->delete();
        return response()->json(['success' => 'Notification deleted']);
    }

    // Mark all as read
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => 'All notifications marked as read']);
    }

    // Delete all notifications
    public function deleteAll()
    {
        Auth::user()->notifications()->delete();
        return response()->json(['success' => 'All notifications deleted']);
    }
}
