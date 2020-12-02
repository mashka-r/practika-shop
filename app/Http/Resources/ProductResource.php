<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {   
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'category'      => CategoryResource::make($this->whenLoaded('category')),
            'price'         => $this->price,
            'code'          => $this->code,
            'count_store'   => $this->count_store,
            'count_res'     => $this->count_res,
            'description'   => $this->description,
        ];
    }
}
