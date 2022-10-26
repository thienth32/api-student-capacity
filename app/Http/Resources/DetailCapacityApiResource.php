<?php

namespace App\Http\Resources;

use App\Http\Resources\RoundCapacityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailCapacityApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'img' => $this->img,
            'date_start' => $this->date_start,
            'register_deadline' => $this->register_deadline,
            'description' => $this->description,
            'status' => $this->status,
            'type' => $this->type,
            'status' => $this->status,
            'user_capacity_done_count' => $this->whenCounted('userCapacityDone'),
            'rounds_count' => $this->whenCounted('rounds'),
            'slug_name' => $this->slug_name,
            'rounds' =>  RoundCapacityResource::collection($this->whenLoaded('rounds')),
            'recruitmentEnterprise' => EnterpriseRecruitmentResource::collection($this->whenLoaded('recruitmentEnterprise')),

        ];
    }
}