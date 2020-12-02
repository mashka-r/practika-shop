<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class OrderProductResource extends JsonResource
{
    public function toArray($request)
    {   
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'price'     => $this->price,
            'count'     => $this->pivot->count,
            'category'  => CategoryResource::make($this->whenLoaded('category')),
        ];
    }
}
