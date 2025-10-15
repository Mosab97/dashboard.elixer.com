<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Models\RealResultProduct;

class RealResult extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'image_before',
        'image_after',
        'active',
        'order'
    ];

    protected $translatable = ['name', 'description'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'real_result_products');
    }
    public function real_result_products()
    {
        return $this->hasMany(RealResultProduct::class);
    }

    public function getImageBeforePathAttribute()
    {
        if ($this->image_before) {
            if (str_starts_with($this->image_before, 'media/real-results/')) {
                return asset($this->image_before);
            }
            return asset('storage/' . $this->image_before);
        }
        return null;
    }

    public function getImageAfterPathAttribute()
    {
        if ($this->image_after) {
            if (str_starts_with($this->image_after, 'media/real-results/')) {
                return asset($this->image_after);
            }
            return asset('storage/' . $this->image_after);
        }
        return null;
    }

    // /**
    //  * Helper method to sync products
    //  * @param array $productIds
    //  * @return void
    //  */
    // public function syncProducts(array $productIds)
    // {
    //     RealResultProduct::whereNotIn('product_id', $productIds)->delete();
    //     foreach ($productIds as $productId) {
    //         RealResultProduct::updateOrCreate([
    //             'real_result_id' => $this->id,
    //             'product_id' => $productId,
    //         ], [
    //             'active' => true,
    //         ]);
    //     }
    // }
}
