<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'region_id',
        'address',
        'coupon_code',
        'delivery_method',
        'payment_method',
        'read_conditions',
        'sub_total',
        'delivery_fee',
        'total_price_before_discount',
        'discount',
        'total_price_after_discount',
        'status'
    ];



    protected $casts = [
        'sub_total' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_price_before_discount' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_price_after_discount' => 'decimal:2',
        'read_conditions' => 'boolean',
        'payment_method' => \App\Enums\PaymentMethod::class,
        'delivery_method' => \App\Enums\DeliveryMethod::class,
        'status' => \App\Enums\OrderStatus::class,
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }
    public function region()
    {
        return $this->belongsTo(Address::class, 'region_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
