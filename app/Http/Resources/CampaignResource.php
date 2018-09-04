<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CampaignResource extends Resource
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
            'message' => $this->message,
            'receivers' => $this->receivers,
            'status' => $this->status,
            'created_at' => (string) $this->created_at,
        ];
    }
}
