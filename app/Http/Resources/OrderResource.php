<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderProductResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'phone'      => $this->phone,
            'products'   => OrderProductResource::collection($this->whenLoaded('products')),
            'status'     => $this->status()
                                    ->where('id', $this->status)
                                    ->get('description'),
        ];
    }
}
