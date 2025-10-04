<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Address extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $translatable = ['title', 'address'];
    protected $fillable = ['title', 'address', 'price', 'active', 'order'];

    protected $casts = [
        'title' => 'array',
        'address' => 'array',
        'price' => 'decimal:2',
        'active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
