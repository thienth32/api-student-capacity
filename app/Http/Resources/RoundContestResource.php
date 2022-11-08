<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoundContestResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'description' => $this->description,
            'type_exam_id' => $this->type_exam_id,
            'user_status_join' => $this->user_status_join,
            'teams' =>  TeamResource::collection($this->whenLoaded('teams')),
            'judges' => JudgesRoundContestResource::collection($this->whenLoaded('judges')),
        ];
    }
}