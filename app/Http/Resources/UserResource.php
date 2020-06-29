<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return [
                'id'    => $this->id,
                'name'  => $this->name,
                'email' => $this->email,
                'role'  => $this->roles()->where('user_id', $this->id)->get(['name']),
            ];
        } else {
            return [
                'name'  => $this->name,
                'email' => $this->email,
            ];
        }
    }
}
