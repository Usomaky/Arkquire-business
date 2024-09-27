<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Business extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ends' => 'datetime'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function watchers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Event listener for the 'created' event
        static::created(function ($business) {
            // Increment the business count for the associated category
            $business->category->increment('business_count');
        });

        // Event listener for the 'deleted' event
        static::deleted(function ($business) {
            // Decrement the business count for the associated category
            $business->category->decrement('business_count');
        });

        // Event listener for the 'updated' event
        static::updated(function ($business) {
            // Check if the category_id has changed
            if ($business->isDirty('category_id')) {
                // Get the old and new category IDs
                $oldCategoryId = $business->getOriginal('category_id');
                $newCategoryId = $business->category_id;

                // Decrement count from the old category
                Category::find($oldCategoryId)?->decrement('business_count');

                // Increment count for the new category
                Category::find($newCategoryId)?->increment('business_count');
            }
        });
    }

    // Define the relationship with the Category model
   

}
