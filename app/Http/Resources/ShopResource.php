<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            'category' => $this->category,
            'file_path' => $this->file_path,
            'created_at' => $this->created_at,
            'price_in_eur' => $this->price_in_eur,
            'work_name' => $this->work_name,
            'description' => $this->description,
        ];
    }
}
