<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {

        $fields = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'region_id' => $this->region_id,
            'address' => $this->address,
            'coupon_code' => $this->coupon_code,
            'payment_method' => $this->payment_method,
            'read_conditions' => (bool)$this->read_conditions,
            'sub_total' => (float)$this->sub_total,
            'total_price_before_discount' => (float)$this->total_price_before_discount,
            'delivery_fee' => (float)$this->delivery_fee,
            'discount' => (float)$this->discount,
            'total_price_after_discount' => (float)$this->total_price_after_discount,
            'items' => $this->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => (int)$item->quantity,
                    'price' => (float)$item->price,
                    'total' => (float)$item->total,
                    'product' => new ProductResource($item->product),
                ];
            }),
        ];

        return $fields;
    }
}
