<?php
namespace Modules\Notifications\Models;

use Modules\Notifications\Models\NotificationSubGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'icon', 'order'];

    public function subGroups(): HasMany
    {
        return $this->hasMany(NotificationSubGroup::class);
    }
}
