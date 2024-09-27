<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'category_name', 'status',
    ];


    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
