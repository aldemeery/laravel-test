<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use App\Http\Resources\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'status' => $this->status,
            'user' => new User($this->whenLoaded('user')),
            'post' => new Post($this->whenLoaded('post')),
        ];
    }
}
