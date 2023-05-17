<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResoucre extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title' => $this->title,
            'image' => str_replace('public/', 'storage/', $this->image),
            'video' => str_replace('public/', 'storage/', $this->video) ?? null,
            'desc' => $this->desc,
            'user_id' => $this->user_id,
            'location'=>$this->location,
            'condition'=>$this->condition
        ];
    }
}
