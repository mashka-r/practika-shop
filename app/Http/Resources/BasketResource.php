<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use  App\Http\Resources\ProductResource;
use App\Models\Product;

class BasketResource extends JsonResource
{
    public function toArray($request)
    {  
        return [
            'temporary_key'  => $this->temporary_key,
            'product_id' => ProductResource::make(Product::find($this->product_id)),
            'count'  => $this->count,
        ];
    }
}
