<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

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
        $route = Route::currentRouteName();
        
        if ((stripos($route, 'orders')) === true) {
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
                'description'   => $this->description,
            ];
        }
}
}