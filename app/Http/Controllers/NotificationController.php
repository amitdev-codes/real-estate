<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function index()
    {
        $user = auth()->user();
        $notifications = $this->notificationService->getNotificationsByRole($user);
        $groups = $this->notificationService->getGroupsByRole($user->role);
        return Inertia::render('backend/pages/notifications/index', [
            'notifications' => [
                'data' => $notifications,
                'unread_count' => $this->notificationService->getUnreadCount($user),

            ],
            'groups' => $groups,
        ]);
    }

    public function viewNotifications($id = null)
    {
        $user = auth()->user();

        if ($id) {
            // Single notification view
            $notification = Notification::findOrFail($id);

            return Inertia::render('backend/pages/notifications/viewNotification', [
                'notification' => $notification,
            ]);
        }

        // All notifications view
        // $notifications = $this->notificationService->getNotificationsByRole($user);

        // return Inertia::render('backend/pages/notifications/index', [
        //     'notifications' => [
        //         'data' => $notifications,
        //         'meta' => [
        //             'unread_count' => $this->notificationService->getUnreadCount($user),
        //         ],
        //     ],
        // ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read_at = now();
        $notification->save();

        return back()->with('success', 'Notification marked as read');
    }
    public function bulkMarkAsRead(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);
        $ids = $request->ids;
        Notification::whereIn('id', $ids)->update(['read_at' => now()]);
        return back()->with('success', 'Notification marked as read');
    }

    public function getNotifications()
    {
        $user = auth()->user();
        $notifications = $this->notificationService->getNotificationsByRole($user);
        $groups = $this->notificationService->getGroupsByRole($user->role);

        return response()->json([
            'notifications' => $notifications,
            'groups' => $groups,
        ]);
    }

    // public function markAsRead(Request $request, $id)
    // {
    //     $notification = Notification::find($id);
    //     if (!$notification) {
    //         return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    //     }
    //     $notification->markAsRead();
    //     return response()->json(['success' => true]);
    // }

    public function getUnreadCount()
    {
        $count = $this->notificationService->getUnreadCount(auth()->user());

        return response()->json(['count' => $count]);
    }

    // app/Http/Controllers/NotificationController.php
    public function reply(Request $request, Notification $notification)
    {
        $request->validate([
            'notificationId' => 'required',
            'remarks' => 'required|string',
        ]);
        $notification = Notification::find($request->notificationId);
        $notification->reply = $request->remarks;
        $notification->read_at = $notification->read_at ?? now();
        $notification->replied_at = now();
        $notification->replied_by = auth()->id();
        $notification->save();

        return response()->json([
            'message' => 'Reply added successfully',
            'notification' => $notification->load('repliedByUser'),
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $ids = $request->ids;
        Notification::whereIn('id', $ids)->delete();
        return response()->json(['message' => 'Notifications deleted successfully']);
    }
}
