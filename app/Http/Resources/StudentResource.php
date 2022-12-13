<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'name' => $this->full_name,
            'email' => $this->email,
            'image' => $this->image_url,
            'phone' => $this->phone,
            'address' => $this->address,
            'rate' => $this->rate,
            'transport' => $this->transport,
            'status' => $this->status,
            'total_income' => $this->total_income,
            'total_jobs' => $this->total_jobs,
            'gender'=>$this->gender,
            'groups'=>$this->groups,
        ];
    }
}