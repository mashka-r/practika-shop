<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use  App\Http\Resources\ProductResource;

class OrderResource extends JsonResource
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
            'id'         => $this->id,
            'name'       => $this->name,
            'phone'      => $this->phone,
            'product(s)' => ProductResource::collection($this->products()
                                                                ->where('order_id', $this->id)
                                                                ->get()),
            'status'     => $this->status()
                                    ->where('id', '=', $this->status)
                                    ->get('description'),
        ];
    }
}
