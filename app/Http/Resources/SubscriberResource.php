<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' =>$this->title,
            'user_id' => $this->user_id,
            'websites_id' => $this->websites_id,
            'created_at' => $this->created_at
        ];
    }
}
