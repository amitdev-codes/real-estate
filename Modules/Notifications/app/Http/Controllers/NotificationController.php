<?php

namespace Modules\Notifications\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Notifications\Http\Requests\StoreNotificationRequest;
use Modules\Notifications\Http\Requests\UpdateNotificationRequest;
use Modules\Notifications\Models\Notification;
use Modules\Notifications\Models\NotificationGroup;
use Modules\Notifications\Models\NotificationSubGroup;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['property', 'group'])
            ->latest()
            ->paginate(10)
            ->through(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'group' => $notification->group,
                    'subgroups' => $notification->subGroups, // Get the subgroups
                    'sender_name' => $notification->sender_name, // Get the sender's name
                    'email' => $notification->email,
                    'phone' => $notification->phone,
                    'postcode' => $notification->postcode,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at,
                ];
            });

        $groups = NotificationGroup::all();
        $subGroups = NotificationSubGroup::all();

        return Inertia::render('Notifications::notifications/index', [
            'notifications' => $notifications,
            'groups' => $groups,
            'subGroups' => $subGroups,
        ]);
    }

    public function store(StoreNotificationRequest $request)
    {
        $validatedData = $request->validated();
        $notification = Notification::create($validatedData);

        return response()->json([
            'message' => 'Notification Send successfully',
            'notification' => $notification,
        ]);
    }

    public function show(Notification $notification)
    {
        return Inertia::render('Notifications/Show', [
            'notification' => $notification->load(['property', 'repliedByUser']),
        ]);
    }

    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $validatedData = $request->validated();
        $notification->update($validatedData);

        return response()->json([
            'message' => 'Notification updated successfully',
            'notification' => $notification->fresh(),
        ]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted successfully',
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:notifications,id',
        ]);

        Notification::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => 'Selected notifications deleted successfully',
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['read_at' => now()]);

        return response()->json([
            'message' => 'Notification marked as read',
            'notification' => $notification->fresh(),
        ]);
    }

    public function bulkMarkAsRead(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:notifications,id',
        ]);

        Notification::whereIn('id', $request->ids)->update(['read_at' => now()]);

        return response()->json([
            'message' => 'Selected notifications marked as read',
        ]);
    }

    public function getUnreadCount()
    {
        $count = Notification::whereNull('read_at')->count();

        return response()->json([
            'unread_count' => $count,
        ]);
    }

    public function reply(Request $request, Notification $notification)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);
        $notification->reply = $request->reply; // Use 'remarks' instead of 'reply'
        $notification->read_at = $notification->read_at ?? now(); // Mark as read if not already
        $notification->replied_at = now(); // Set the replied_at timestamp
        $notification->replied_by = auth()->id(); // Set the ID of the user replying
        $notification->save();

        return response()->json([
            'message' => 'Reply added successfully',
            'notification' => $notification->load('repliedByUser '), // Load the repliedByUser  relationship
        ]);
    }

    public function getNotifications(Request $request)
    {
        $notifications = Notification::with(['group'])
            ->where('notifiable_id', auth()->id())
            ->latest()
            ->get();

        // Group notifications by group
        $groupedNotifications = $notifications
            ->groupBy('group.name')
            ->map(function ($group) {
                // Sort messages within each group by date
                return $group->sortByDesc('created_at')->values();
            })
            ->filter(function ($group) {
                // Only include groups that have messages
                return $group->isNotEmpty();
            });

        return response()->json([
            'notifications' => $groupedNotifications,
            'unread_count' => $notifications->whereNull('read_at')->count(),
        ]);
    }

    public function viewGroupNotifications($groupName)
    {
        $notifications = Notification::with(['group'])
            ->whereHas('group', function ($query) use ($groupName) {
                $query->where('name', $groupName);
            })
            ->where('notifiable_id', auth()->id())
            ->latest()
            ->paginate(15);

        return inertia('Notifications/Group', [
            'notifications' => $notifications,
            'groupName' => $groupName,
        ]);
    }
}
