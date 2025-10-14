<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $fields = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image_path,
            'category' => $this->whenLoaded('category', function () {
                return new CategoryResource($this->category);
            }),
            'attachments' => $this->whenLoaded('attachments', function () {
                return AttachmentResource::collection($this->attachments);
            }),
            'description' => $this->description,
            'discount' => $this->discount ?? 0,
            'price' => $this->price ?? 0,
            'price_after_discount' => $this->price_after_discount ?? 0,
            'featured' => $this->featured ?? false,
            'active' => $this->active ?? false,
            'order' => $this->order ?? 0,
            'quantity' => $this->quantity ?? 0,
        ];

        return $fields;
    }
}
