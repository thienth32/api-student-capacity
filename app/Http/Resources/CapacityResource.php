<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CapacityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'img' => $this->img,
            'date_start' => $this->date_start,
            'register_deadline' => $this->register_deadline,
            'status_user_has_join_contest' => $this->status_user_has_join_contest,
            'user_capacity_done_count' => $this->whenCounted('userCapacityDone'),
            'rounds_count' => $this->whenCounted('rounds'),
            'teams_count' => $this->whenCounted('teams'),
            'slug_name' => $this->slug_name,
            'user_top' => new UserTopResource($this->user_top),
            'rounds' =>  RoundCapacityResource::collection($this->whenLoaded('rounds')),
            'recruitmentEnterprise' => EnterpriseRecruitmentResource::collection($this->whenLoaded('recruitmentEnterprise')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
        ];
        if ($request->route()->getName() == "capacity.api.related") {
            $data = array_merge($data, [
                'description' => $this->description
            ]);
        }
        return $data;
    }
}
