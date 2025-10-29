<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class HowWeWorkResource extends JsonResource
{
    public function toArray($request)
    {

        $fields = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon_path,
            'active' => $this->active,
            'order' => $this->order,
        ];

        return $fields;
    }
}
