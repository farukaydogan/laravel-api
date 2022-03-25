<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class UserResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            '_id' => $this->id,
            '_name' => $this->name,
            '_first_name' => $this->first_name,
            '_last_name' => $this->last_name,
            '_isadmin' => $this->when($this->id == 1, true),
        ];
    }
}
