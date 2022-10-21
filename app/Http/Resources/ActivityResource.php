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
            'project' => $this->project->title,
            'activity Type' => $this->activityType->name,
            'project_id' => $this->project_id,
            'activity_type_id' => $this->activity_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image_url,
            'date' => $this->date,

        ];
    }
}
