<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {

        $fields = [
            'category' => $this->whenLoaded('category', function () {
                return new CategoryResource($this->category);
            }),
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image_path,
            'discount' => $this->discount ?? 0,
            'price' => $this->price ?? 0,
            'featured' => $this->featured ?? false,
            'active' => $this->active ?? false,
            'order' => $this->order ?? 0,
            'quantity' => $this->quantity ?? 0,
        ];

        return $fields;
    }
}
