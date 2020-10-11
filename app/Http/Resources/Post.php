<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use App\Http\Resources\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'user' => new User($this->whenLoaded('user')),
            'comments' => Comment::collection($this->whenLoaded('comments')),
        ];
    }
}
