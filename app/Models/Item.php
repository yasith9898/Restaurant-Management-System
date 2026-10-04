<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_ar', 'name_ku', 'name_tr', 'name_fa',
        'desc_en', 'desc_ar', 'desc_ku', 'desc_tr', 'desc_fa',
        'normal_price', 'price_with_ice_cream', 'price_per_kilo',
        'currency', 'cover_image', 'category_id', 'is_active', 'slug'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'normal_price' => 'decimal:2',
        'price_with_ice_cream' => 'decimal:2',
        'price_per_kilo' => 'decimal:2'
    ];

    protected $appends = ['cover_image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // FIXED: Proper image URL accessor for items
    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return asset('images/default-item.png');
        }

        // If it's already a full URL, return as is
        if (filter_var($this->cover_image, FILTER_VALIDATE_URL)) {
            return $this->cover_image;
        }

        // Check if image exists in storage and return full URL
        if (Storage::disk('public')->exists($this->cover_image)) {
            return Storage::disk('public')->url($this->cover_image);
        }

        // Fallback to default image
        return asset('images/default-item.png');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            // If slug not provided, generate from English name
            if (empty($item->slug)) {
                $base = Str::slug($item->name_en ?: time());
                $slug = $base;
                $counter = 1;

                while (self::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $counter++;
                }

                $item->slug = $slug;
            }
        });
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
}
