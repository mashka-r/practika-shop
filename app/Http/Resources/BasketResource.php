<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use  App\Http\Resources\ProductResource;

class BasketResource extends JsonResource
{
    public function toArray($request)
    {  
        return [
            'temporary_key'  => $this->temporary_key,
            'product' => ProductResource::make($this->whenLoaded('product')),
            'count'  => $this->count,
        ];
    }
}
