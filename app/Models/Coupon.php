<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'discount', 'expiry_date', 'active'];

    protected $casts = [
        'code' => 'string',
        'discount' => 'decimal:2',
        'expiry_date' => 'date',
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    public function scopeValid($query)
    {
        return $query->where('expiry_date', '>', now());
    }
}
