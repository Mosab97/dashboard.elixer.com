<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    public function toArray($request)
    {
        $fields = [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'file_path' => $this->file_path,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];

        return $fields;
    }
}
