<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(20);
        return view('syndic.notifications.index', compact('notifications'));
    }

    public function unreadCount(Request $request): JsonResponse
    {
        return response()->json(['count' => $request->user()->unreadNotifications()->count()]);
    }

    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Notifications marquées comme lues.');
    }
}
