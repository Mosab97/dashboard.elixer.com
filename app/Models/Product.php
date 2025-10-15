<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'price',
        'discount',
        'price_after_discount',
        'featured',
        'rate_count',
        'active',
        'order',
        'quantity',
    ];

    protected $translatable = ['name', 'description'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'discount' => 'decimal:2',
        'price' => 'decimal:2',
        'price_after_discount' => 'decimal:2',
        'featured' => 'boolean',
        'rate_count' => 'integer',
        'active' => 'boolean',
        'order' => 'integer',
        'quantity' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }


    public function getImagePathAttribute()
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'media/products/')) {
                return asset($this->image);
            }
            return asset('storage/' . $this->image);
        }
        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%')
            ->orWhere('description', 'like', '%' . $value . '%');
    }
}
