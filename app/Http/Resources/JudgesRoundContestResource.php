<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JudgesRoundContestResource extends JsonResource
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
            'name' => $this->user->name,
            'avatar' => $this->user->avatar,
            'email' => $this->user->email,
            'pivot' => $this->pivot,
        ];
    }
}