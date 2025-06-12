<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)
            ->where('status', 'unread')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|exists:notifications,id'
        ]);

        $notification = Notification::where('id', $request->notification_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($notification) {
            $notification->update(['status' => 'read']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }
}