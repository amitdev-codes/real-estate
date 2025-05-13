<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Property\Models\Property;

class Notification extends Model
{
    protected $fillable = [
        'message', 'first_name', 'last_name', 'email', 'phone', 'postcode',
        'notification_group_id',
        'notification_sub_group_ids',
        'notifiable_id',
        'notifiable_type', 'property_id',
        'data', 'reply', 'replied_at', 'replied_by',
    ];

    protected $casts = [
        'notification_sub_group_ids' => 'array',
        'data' => 'array',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(NotificationGroup::class, 'notification_group_id');
    }

    public function getSenderNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getSubGroupsAttribute()
    {
        $subGroupIds = $this->notification_sub_group_ids ?? [];

        return NotificationSubGroup::whereIn('id', $subGroupIds)->get();
    }

    // Mutator for notification_sub_group_ids
    public function setNotificationSubGroupIdsAttribute($value)
    {
        // Convert to array if it's not already
        if (! is_array($value)) {
            $value = json_decode($value, true);
        }

        // Convert all values to integers and encode as JSON
        $this->attributes['notification_sub_group_ids'] = json_encode(array_map('intval', $value));
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
