<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'topic_title' => $this->topic_title,
            'topic_description' => $this->topic_description,
            'created_at' => $this->created_at,
            'user_id'=> $this->user->name,
            'file_path' => $this->file_path,
        ];
    }
}