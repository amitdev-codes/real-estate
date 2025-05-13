<?php

namespace Modules\Notifications\Models;

use App\Models\NotificationGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationSubGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['notification_group_id', 'name', 'slug', 'icon', 'order'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(NotificationGroup::class, 'notification_group_id');
    }
}
