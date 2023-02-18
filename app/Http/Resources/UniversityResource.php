<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UniversityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'categories'=>$this->categories,
            'contact_file'=>asset($this->contractFile),
            'name'=>$this->name,
            'min_price'=>$this->min_price,
            'min_ielts'=>$this->min_ielts,
            'city_name'=>$this->city_name,
            'image'=>asset($this->image),
            'created_at'=>$this->created_at->diffForHumans(),
            'updated_at'=>$this->updated_at->diffForHumans(),
        ];
    }
}
