<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'details' => $this->details,
            'image' => $this->image,
            'notes' => $this->notes,
            'attachment' => $this->attachment,
            'deadline' => $this->deadline,
            'status' => $this->status,
        ];
    }
}
