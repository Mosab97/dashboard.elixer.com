<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class FAQResource extends JsonResource
{
    public function toArray($request)
    {
        $fields = [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
        ];

        return $fields;
    }
}
