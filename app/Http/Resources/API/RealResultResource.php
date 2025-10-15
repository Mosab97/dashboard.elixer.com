<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class RealResultResource extends JsonResource
{
    public function toArray($request)
    {

        $fields = [
            'id' => $this->id,

            'name' => $this->name,
            'description' => $this->description,
            'image_before' => $this->image_before_path,
            'image_after' => $this->image_after_path,
            'duration' => $this->duration,
            'products' => $this->whenLoaded('products', function () {
                return $this->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->image_path,
                    ];
                });
            }),
            'active' => $this->active,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];

        return $fields;
    }
}
