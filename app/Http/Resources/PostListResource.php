<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'auth_id' => $this->auth_id,
            'image' => $this->image,
            'user' => [
                'id' => $this->users->id,
                'first_name' => $this->users->first_name,
                'last_name' => $this->users->last_name,
                'phone' => $this->users->phone,
                'email' => $this->users->email
            ],
        ];
    }
}
