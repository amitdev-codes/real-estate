<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// use Modules\Property\Database\Factories\PropertyTypeFactory;

class PropertyType extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active'];

    protected $appends = ['thumb_url' ,'preview_url', 'image_path'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_no = static::where('parent_id', $model->parent_id)->max('order_no') + 1;
        });
    }

    public function parent()
    {
        return $this->belongsTo(PropertyType::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PropertyType::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    // public function properties()
    // {
    //     return $this->hasMany(Property::class, 'property_type_id');
    // }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_property_type');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_property_type');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeActiveProperties($query)
    {
        return $query->whereHas('properties', function ($query) {
            $query->where('is_active', true);
        });
    }
    

    // If all resources are to be counted
    // public function getTotalPropertyCount()
    // {
    //     $directCount = $this->properties()->count();

    //     $childCounts = $this->children->map(function ($child) {
    //         return $child->getTotalPropertyCount();
    //     })->sum();

    //     return $directCount + $childCounts;
    // }

    // public function getActivePropertyCount()
    // {
    //     $directCount = $this->properties()->active()->count();

    //     $childCounts = $this->children->map(function ($child) {
    //         return $child->getActivePropertyCount();
    //     })->sum();

    //     return $directCount + $childCounts;
    // }

    public function getActivePropertyCount()
    {
        $directCount = $this->properties()->where('is_active', true)->count();

        $childCounts = $this->children->map(function ($child) {
            return $child->getActivePropertyCount();
        })->sum();

        return $directCount + $childCounts;
    }

    // public function getHierarchyWithCounts()
    // {
    //     return $this->children->map(function ($child) {
    //         return [
    //             'name' => $child->name,
    //             'count' => $child->getActivePropertyCount(),
    //             'children' => $child->getHierarchyWithCounts(),
    //         ];
    //     });
    // }

    public function getHierarchyWithCounts()
    {
        return $this->children->map(function ($child) {
            return [
                'name' => $child->name,
                'count' => $child->getActivePropertyCount(),
                'children' => $child->getHierarchyWithCounts(),
            ];
        })->toArray();
    }

    public function displayHierarchy($level = 0)
    {
        $output = str_repeat('-', $level) . " {$this->name} ({$this->getActivePropertyCount()})\n";

        foreach ($this->children as $child) {
            $output .= $child->displayHierarchy($level + 1);
        }

        return $output;
    }

    public function hasActiveProperties()
    {
        return $this->properties()->where('is_active', true)->exists() || $this->children->contains(function ($child) {
            return $child->hasActiveProperties();
        });
    }

    public function hasChildren()
    {
        return $this->children()->exists();
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
            // ->useFallbackUrl('/assets/img/illustrations/page-misc-error-light.png')
            // ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 120, 120)
            ->performOnCollections('images')
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 600, 800)
            ->performOnCollections('images')
            ->nonQueued();
    }

    public function getPreviewUrlAttribute(){
        return $this->getMedia('images')->map(function ($media) {
            return $media->getUrl('preview');
        });
    }

    public function getThumbUrlAttribute(){
        return $this->getMedia('images')->map(function ($media) {
            return $media->getUrl('thumb');
        });
    }

    public function getImagePathAttribute(){
        return $this->getMedia('images')->map(function ($media) {
            return ltrim($media->original_url, '/');
        });
    }
}
