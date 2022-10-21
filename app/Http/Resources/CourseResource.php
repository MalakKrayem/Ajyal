<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'hour_count'=>$this->hour_count,
            'status'=>$this->status,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            "group_id"=>$this->group_id,
            "mentor_id"=>$this->mentor_id,
            "group"=>$this->group->title,
            "mentor"=>$this->mentor->full_name,
        ];
        }
}
