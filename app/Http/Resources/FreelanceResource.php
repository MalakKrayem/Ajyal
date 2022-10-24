<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FreelanceResource extends JsonResource
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
            'platform_id' => $this->platform_id,
            'student_id' => $this->student_id,
            'group_id' => $this->group_id,
            'platform' => $this->platform->name,
            'student' => $this->student->full_name,
            'group' => $this->group->title,
            'job_title' => $this->job_title,
            'job_description' => $this->job_description,
            'job_link' => $this->job_link,
            'attachment' => $this->attachment_url,
            'salary' => $this->salary,
            'client_feedback' => $this->client_feedback,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}
