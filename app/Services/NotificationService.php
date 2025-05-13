<?php
namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationGroup;
use App\Events\NotificationCreated;
use Illuminate\Database\Eloquent\Builder;

class NotificationService
{
    public function createNotification(
        string $groupSlug,
        string $type,
        $notifiable,
        string $title,
        string $message,
        array $data = []
    ): Notification {
        $group = NotificationGroup::where('slug', $groupSlug)->firstOrFail();

        $notification = Notification::create([
            'notification_group_id' => $group->id,
            'type' => $type,
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ]);

        // event(new NotificationCreated($notification));

        return $notification;
    }
    public function getNotificationsByRole($user)
    {
        // dd(get_class($user));
        // dd($user->roles);
        return Notification::with('group')
            // ->where('notifiable_type', get_class($user))
            ->where('notifiable_id', $user->id)
            // ->whereHas('group', function (Builder $query) use ($user) {
            //     $query->where('role', $user->role);
            // })
            ->latest()
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'type' => $notification->type,
                    'message' => $notification->message,
                    'created_at' => $notification->created_at,
                    'read_at' => $notification->read_at,
                    'group' => [
                        'id' => $notification->group->id,
                        'name' => $notification->group->name,
                        'icon' => $notification->group->icon,
                        'type' => $notification->group->type
                    ]
                ];
            });
    }

    public function getGroupsByRole($role)
    {
        // dd($role);
        return NotificationGroup::get()
            ->map(function ($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'icon' => $group->icon,
                    'type' => $group->type
                ];
            });
    }

    public function getUnreadCount($notifiable): int
    {
        return Notification::where('notifiable_id', $notifiable->id)
            ->whereNull('read_at')
            ->count();
    }
}
