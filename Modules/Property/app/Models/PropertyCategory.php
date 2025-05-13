<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'description', 'order_no', 'is_active', ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_no = static::max('id') + 1;
        });
    }

       // Define the relationship for parent-child categories
       public function children()
       {
           return $this->belongsToMany(
               PropertyCategory::class,
               'category_relationships',
               'parent_id',
               'child_id'
           )->withTimestamps();
       }

       public function parents()
       {
           return $this->belongsToMany(
               PropertyCategory::class,
               'category_relationships',
               'child_id',
               'parent_id'
           )->withTimestamps();
       }

 // Define many-to-many relationships
    // public function parents()
    // {
    //     return $this->belongsToMany(self::class, 'category_relationships', 'child_id', 'parent_id');
    // }

    // public function children()
    // {
    //     return $this->belongsToMany(self::class, 'category_relationships', 'parent_id', 'child_id');
    // }

    //   /**
    //  * Get the parent category.
    //  */
    // public function parent()
    // {
    //     return $this->belongsTo(PropertyCategory::class, 'parent_id');
    // }

    // /**
    //  * Get the child categories.
    //  */
    // public function children()
    // {
    //     return $this->hasMany(PropertyCategory::class, 'parent_id', 'id')->with('children');
    // }

    /**
     * Get the child categories.
     */
    public function subChildren()
    {
        return $this->hasMany(PropertyCategory::class, 'parent_id')->with('children');
    }

    /**
     * Recursively get all subcategories.
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
