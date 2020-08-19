<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        if (stripos($request->path(), 'orders')) {
            return [
                'id'      => $this->id,
                'name'   => $this->name,
                'price'   => $this->price,
                'count'   => $this->pivot->count,
            ];

        } else {
            return [
                'id'            => $this->id,
                'name'          => $this->name,
                'price'         => $this->price,
                'code'          => $this->code,
                'count_store'   => $this->count_store,
                'count_res'     => $this->count_res,
                'description'   => $this->description,
            ];
        }
}
}
