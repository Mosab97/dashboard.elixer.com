<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {

        $fields = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        return $fields;
    }
}
