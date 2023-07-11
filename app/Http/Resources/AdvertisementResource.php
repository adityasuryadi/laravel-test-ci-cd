<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        if(is_null($this->resource)) {
            return [];
        }

        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'source_url'=>url('/storage/'.$this->source_url),
            'link'=>$this->link,
            'duration'=>$this->duration
        ];
    }
}
