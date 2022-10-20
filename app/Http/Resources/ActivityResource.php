<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'project_id' => $this->project->title,
            'activity_type_id' => $this->activityType->name,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image_url,
            'date' => $this->date,

        ];
    }
}
