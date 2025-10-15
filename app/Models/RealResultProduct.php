<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RealResult;
use App\Models\Product;

class RealResultProduct extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'real_result_products';
    protected $fillable = ['real_result_id', 'product_id', 'active', 'order'];

    public function real_result()
    {
        return $this->belongsTo(RealResult::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
