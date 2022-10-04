<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'description' => $this->description,
            'image'=>$this->image_url,
            'budget'=>$this->budget,
            'hour_count'=>$this->hour_count,
            'participants_count'=>$this->participants_count,
            'status'=>$this->status,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'relations' => [
                'category' => [
                    'id' => $this->category->id,
                    'name' => $this->category->title,
                ],
                'project' => [
                    'id' => $this->project->id,
                    'name' => $this->project->title,
                ],
            ],

        ];    }
}
