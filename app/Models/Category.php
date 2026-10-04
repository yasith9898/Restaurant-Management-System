<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_ar', 'name_ku', 'name_tr', 'name_fa',
        'desc_en', 'desc_ar', 'desc_ku', 'desc_tr', 'desc_fa',
        'image', 'slug', 'order', 'is_active', 'total_items'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $appends = ['image_url'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // FIXED: Proper image URL accessor
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-category.png');
        }

        // If it's already a full URL, return as is
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Check if image exists in storage and return full URL
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        // Fallback to default image
        return asset('images/default-category.png');
    }

    // Accessor for getting name in current language
    public function getNameAttribute()
    {
        $lang = session('language', 'en');
        $nameField = "name_{$lang}";

        return $this->$nameField ?? $this->name_en;
    }

    // Accessor for getting description in current language
    public function getDescriptionAttribute()
    {
        $lang = session('language', 'en');
        $descField = "desc_{$lang}";

        return $this->$descField ?? $this->desc_en;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Str::slug($category->name_en);
            }
        });
    }
}
