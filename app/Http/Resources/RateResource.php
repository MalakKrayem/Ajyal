<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
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
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'student' => $this->student->full_name,
            'course' => $this->course->title,
            'rate' => $this->rate,
            'notes' => $this->notes,
        ];
    }
}
