<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailContestResource extends JsonResource
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
            'major_id' => $this->major_id,
            'status' => $this->status,
            'type' => $this->type,
            'start_register_time' => $this->start_register_time,
            'end_register_time' => $this->end_register_time,
            'max_user' => $this->max_user,
            'reward_rank_point' => $this->reward_rank_point,
            'post_new' => $this->post_new,
            'slug_name' => $this->slug_name,
            'status_user_has_join_contest' => $this->status_user_has_join_contest,
            'user_wishlist' => $this->user_wishlist,
            'slug_name' => $this->slug_name,
            'rounds_count' => $this->whenCounted('rounds'),
            'user_capacity_done_count' => $this->whenCounted('userCapacityDone'),
            'teams' =>  TeamResource::collection($this->whenLoaded('teams')),
            'rounds' => RoundContestResource::collection($this->whenLoaded('rounds')),
            'judges' => $this->whenLoaded('judges'),
            'image_banner' => $this->image_banner
        ];
    }
}
