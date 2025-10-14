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
            'discount' => (float) $this->discount ?? 0,
            'price' => (float) $this->price ?? 0,
            'price_after_discount' => (float) $this->price_after_discount ?? 0,
            'featured' => (bool) $this->featured ?? false,
            'active' => (bool) $this->active ?? false,
            'order' => $this->order ?? 0,
            'quantity' => (int) $this->quantity ?? 0,
            'rate_count' => (int) $this->rate_count ?? 0,

        ];

        return $fields;
    }
}
