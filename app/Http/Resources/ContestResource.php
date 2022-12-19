<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContestResource extends JsonResource
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
            // 'img' => $this->img,
            'date_start' => $this->date_start,
            'register_deadline' => $this->register_deadline,
            // 'description' => $this->description,
            // 'major_id' => $this->major_id,
            'status' => $this->status,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            // 'deleted_at' => $this->deleted_at,
            'start_register_time' => $this->start_register_time,
            'end_register_time' => $this->end_register_time,
            'max_user' => $this->max_user,
            // 'reward_rank_point' => $this->reward_rank_point,
            // 'post_new' => $this->post_new,
            'type' => $this->type,
            'image_banner' => $this->image_banner,
            'teams_count' => $this->teams_count,
            'rounds_count' => $this->rounds_count,
            'user_capacity_done_count' => $this->user_capacity_done_count,
            'slug_name' => $this->slug_name,
            'status_user_has_join_contest' => $this->status_user_has_join_contest,
            'user_wishlist' => $this->user_wishlist,
        ];
    }
}
