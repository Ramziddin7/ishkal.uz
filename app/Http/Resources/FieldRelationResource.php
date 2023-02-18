<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldRelationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
     return [
            'id'=>$this->id,
            'name'=>$this->name,
            'category'=>$this->category,
            'price'=>$this->price,
            'duration'=>$this->duration,
            'description'=>$this->description,
            'created_at'=>$this->created_at->diffForHumans(),
            'updated_at'=>$this->updated_at->diffForHumans(),
            'country'=>$this->country,
            'university'=>$this->university,
        ];
    }
}
